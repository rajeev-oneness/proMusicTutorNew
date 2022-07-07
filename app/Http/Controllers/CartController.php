<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,App\Models\User;
use App\Models\UserCart,App\Models\Offer,DB;
use App\Models\ProductSeries,App\Models\ProductSeriesLession;
use App\Models\Transaction,App\Models\UserProductLessionPurchase;

class CartController extends Controller
{
    public function addOrRemoveCartProduct(Request $req)
    {
        // dd($req->all());
        $rules = [
            'userId' => 'required|numeric|min:1',
            'type_of_product' => 'required|string|in:offer,series,lession',
            // 'type_of_product' => 'required|string',
            'productId' => 'required|numeric|min:1',
            'currency' => 'nullable|string|in:gbp,euro,eur,usd',
            'cartId' => 'nullable|numeric|min:1',
            'action' => 'required|string|in:add,remove',
        ];

        $validator = validator()->make($req->all(), $rules);

        if (!$validator->fails()) {
            $user = User::where('id',$req->userId)->first();
            if($user){
                if($req->type_of_product == 'offer'){
                    $product = Offer::where('id',$req->productId)->first();
                }elseif ($req->type_of_product == 'series') {
                    $product = ProductSeries::where('id',$req->productId)->first();
                }elseif ($req->type_of_product == 'lession') {
                    $product = ProductSeriesLession::where('id',$req->productId)->first();
                }
                if($product){
                    $countToAddOrRemove = 0;
                    $cart = UserCart::select('*')->where('userId',$user->id)->where('productId',$product->id)->where('type_of_product',$req->type_of_product)->where('status',1)->first();
                    if(!$cart && $req->action == 'add'){
                        $cart = new UserCart();
                        $cart->userId = $user->id;
                        $cart->productId = $product->id;
                        $cart->currency = ($req->currency ?? 'usd');
                        $cart->type_of_product = $req->type_of_product;
                        $cart->save();
                        $countToAddOrRemove += 1;
                    }elseif($cart && $req->action == 'remove'){
                        $countToAddOrRemove -= 1;
                        $cart->status = 2;$cart->save();$cart->delete();
                    } elseif($cart && $req->action == 'add'){
                        return errorResponse('Product exists in cart');
                    }
                    return successResponse('Cart Updated successfully', ['cart' => $cart,'countToAddOrRemove' => $countToAddOrRemove]);
                }
                return errorResponse('Invalid Product id for the '.$req->type_of_product);
            }
            return errorResponse('Invalid User id');
        }
        return errorResponse($validator->errors()->first());
    }

    public function convertCartToSameCurrency(Request $req)
    {
        $rules = [
            'userId' => 'required|numeric|min:1',
            'currency' => 'required|string|in:usd,eur,gbp,euro',
        ];
        $validate = validator()->make($req->all(),$rules);
        if(!$validate->fails()){
            UserCart::where('userId',$req->userId)->where('status',1)->update(['currency'=>$req->currency]);
            return successResponse('Cart Updated Success');
        }
        return errorResponse($validate->errors()->first(),$req->all());
    }

    public function getUserCartDetails(Request $req)
    {
        $user = $req->user();$currencyArray = [];
        $cart = UserCart::where('userId',$user->id)->where('status',1)->get();
        foreach ($cart as $key => $cartData) {
            $product = (object)[];
            if($cartData->type_of_product == 'offer'){
                $product = Offer::where('id',$cartData->productId)->first();
            }elseif($cartData->type_of_product == 'series'){
                $product = ProductSeries::where('id',$cartData->productId)->first();
            }elseif($cartData->type_of_product == 'lession'){
                $product = ProductSeriesLession::where('id',$cartData->productId)->first();
            }
            $cartData->product_info = $product;$currencyArray[] = $cartData->currency;
        }
        $cart->currency_array = array_unique($currencyArray);
        return $cart;
    }

    public function getUserCart(Request $req)
    {
        $cart = $this->getUserCartDetails($req);
        return view('auth.user.cart_info',compact('cart'));
    }

    public function afterPaymentCartCheckout(Request $req,$cartInfo)
    {
        $user = $req->user();
        $selectedCartId = decrypt($cartInfo);
        try {
            DB::beginTransaction();
            if(!empty($selectedCartId) && count($selectedCartId) > 0 && !empty($req->transactionId)){
                $transaction = Transaction::where('id',$req->transactionId)->first();
                if($transaction){
                    $whatPurchased = [];
                    foreach ($selectedCartId as $key => $cartId) {
                        $cart = UserCart::where('id',$cartId)->where('userId',$user->id)->where('status',1)->first();
                        if($cart){
                            $cart->status = 3;
                            if($cart->type_of_product == 'offer'){
                                $offer = Offer::where('id',$cart->productId)->withTrashed()->first();
                                if($offer){
                                    foreach ($offer->offer_series as $key => $offerSeries) {
                                        foreach ($offerSeries->series_details->lession as $index => $lession) {
                                            $newLessionPurchase = new UserProductLessionPurchase();
                                            $newLessionPurchase->userId = $user->id;
                                            $newLessionPurchase->productSeriesId = $offerSeries->series_id;
                                            $newLessionPurchase->productSeriesLessionId = $lession->id;
                                            $newLessionPurchase->transactionId = $transaction->id;
                                            $newLessionPurchase->type_of_product = 'offer';
                                            $newLessionPurchase->offerId = $offer->id;
                                            $newLessionPurchase->authorId = $offer->createdBy;
                                            $newLessionPurchase->save();
                                        }
                                    }
                                    $whatPurchased[] = ['name' => $offer->title,'price' => calculateLessionPrice($offer,$transaction->currency,true)];
                                }
                            }elseif($cart->type_of_product == 'series'){
                                $productSeries = ProductSeries::where('id',$cart->productId)->withTrashed()->first();
                                if ($productSeries) {
                                    foreach ($productSeries->lession as $key => $lession) {
                                        $newLessionPurchase = new UserProductLessionPurchase();
                                        $newLessionPurchase->userId = $user->id;
                                        $newLessionPurchase->productSeriesId = $productSeries->id;
                                        $newLessionPurchase->productSeriesLessionId = $lession->id;
                                        $newLessionPurchase->transactionId = $transaction->id;
                                        $newLessionPurchase->type_of_product = 'series';
                                        $newLessionPurchase->authorId = $productSeries->createdBy;
                                        $newLessionPurchase->save();
                                    }
                                    $whatPurchased[] = ['name' => $productSeries->title,'price' => calculateLessionPrice($productSeries,$transaction->currency,true)];
                                }
                            }elseif($cart->type_of_product == 'lession'){
                                $productLession = ProductSeriesLession::where('id', $cart->productId)->withTrashed()->first();
                                if ($productLession) {
                                    $newLessionPurchase = new UserProductLessionPurchase();
                                    $newLessionPurchase->userId = $user->id;
                                    $newLessionPurchase->productSeriesId = $productLession->productSeriesId;
                                    $newLessionPurchase->productSeriesLessionId = $productLession->id;
                                    $newLessionPurchase->transactionId = $transaction->id;
                                    $newLessionPurchase->type_of_product = 'lession';
                                    $newLessionPurchase->authorId = $productLession->createdBy;
                                    $newLessionPurchase->save();
                                    $whatPurchased[] = ['name' => $productLession->title,'price' => calculateLessionPrice($productLession,$transaction->currency,true)];
                                }
                            }
                            $cart->save();
                        }
                    }
                    $data = [
                        'name' => $user->name,
                        'content' => 'You have purchased the following via cart',
                        'data' => $whatPurchased
                    ];
                    sendMail($data,'userCartPurchaseMail',$user->email,'Purchased Product!!!');
                    DB::commit();
                    return redirect(route('cart.purchase.thankyou',[$cartInfo,'transactionId'=>$transaction->id]));
                }
            }
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function thankyouCartPurchase(Request $req, $cartInfo)
    {
        $selectedCartId = decrypt($cartInfo);$user = $req->user();
        $transaction = Transaction::where('id',$req->transactionId)->first();
        if($transaction){
            $cart = UserCart::whereIn('id',$selectedCartId)->where('userId',$user->id)->where('status',3)->get();
            foreach ($cart as $key => $usercart) {
                if($usercart->type_of_product == 'offer'){
                    $usercart->product_info = Offer::where('id',$usercart->productId)->withTrashed()->first();
                }elseif($usercart->type_of_product == 'series'){
                    $usercart->product_info = ProductSeries::where('id',$usercart->productId)->withTrashed()->first();
                }elseif($usercart->type_of_product == 'lession'){
                    $usercart->product_info = ProductSeriesLession::where('id', $usercart->productId)->withTrashed()->first();
                }
            }
            return view('payment.razorpay.cart.thankyou',compact('cart','transaction'));
        }
        // dd('Payment Success');
    }

    public function emptyCart(Request $req)
    {
        // dd($req->all());
        if (auth()->check()) {
            $user_id = auth()->user()->id;

            $data = UserCart::where('userId', $user_id)->delete();
            return redirect()->back()->with('Success', 'Cart is empty');
        } else {
            return redirect()->back()->with('Errors', 'Login to continue');
        }
    }
}
