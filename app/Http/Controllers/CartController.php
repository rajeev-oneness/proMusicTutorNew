<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,App\Models\User;
use App\Models\UserCart,App\Models\Offer;
use App\Models\ProductSeries,App\Models\ProductSeriesLession;

class CartController extends Controller
{
    public function addOrRemoveCartProduct(Request $req)
    {
        $rules = [
            'userId' => 'required|numeric|min:1',
            'type_of_product' => 'required|string|in:offer,series,lession',
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
                    $cart = UserCart::select('*')->where('userId',$user->id)->where('productId',$product->id)->where('type_of_product',$req->type_of_product)->first();
                    if(!$cart && $req->action == 'add'){
                        $cart = new UserCart();
                        $cart->userId = $user->id;
                        $cart->productId = $product->id;
                        $cart->currency = ($req->currency ?? 'usd');
                        $cart->type_of_product = $req->type_of_product;
                        $cart->save();
                    }elseif($cart && $req->action == 'remove'){
                        $cart->status == 2;$cart->save();$cart->delete();
                    }
                    return successResponse('Cart Updated Success',$cart);
                }
                return errorResponse('Invalid Product id for the '.$req->type_of_product);
            }
            return errorResponse('Invalid User id');
        }
        return errorResponse($validator->errors()->first());
    }

    public function getUserCart(Request $req)
    {
        $user = $req->user();
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
            $cartData->product_info = $product;
        }
        // dd($cart);
        return view('auth.user.cart_info',compact('cart'));
    }
}
