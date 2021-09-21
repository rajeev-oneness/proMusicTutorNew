<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,App\Models\ContactUs;
use App\Models\EmailSubscription,App\Models\Faq,App\Models\User;
use App\Models\Testimonial,App\Models\Instrument,App\Models\Category;
use App\Models\ProductSeries,App\Models\SubscriptionPlan;
use App\Models\Transaction,App\Models\UserSubscription;
use App\Models\UserProductLessionPurchase,App\Models\ProductSeriesLession;
use App\Models\Setting,App\Models\UserRating;

class DefaultController extends Controller
{
    public function welcome(Request $req)
    {
        $data = (object)[];
        $data->faq = Faq::get();
        $data->tutor = User::where('user_type',2)->latest()->limit(6)->get();
        $data->testimonial = Testimonial::latest()->limit(2)->get();
        $data->instrument = Instrument::latest()->limit(3)->get();
        return view('welcome',compact('data'));
    }

    public function contactUsFront(Request $req)
    {
        return view('front.contact-us');
    }

    public function contactUsFrontSave(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|string|email|max:200',
            'phone' => 'required|numeric',
            'subject' => 'required|string|max:200',
            'description' => 'nullable|string',
        ]);
        $contact = new ContactUs();
            $contact->name = $req->name;
            $contact->email = $req->email;
            $contact->phone = $req->phone;
            $contact->subject = $req->subject;
            $contact->description = emptyCheck($req->description);
        $contact->save();
        $error['success'] = 'Thankyou for contact we will catch you shortly';
        return back()->withErrors($error);
    }

    public function browserProduct(Request $req)
    {
        $data = (object)[];$user = auth()->user();$data->instrument = [];
        $data->category = Category::select('*');
        $data->guitarSeries = ProductSeries::select('*');
        if(!empty($req->instrumentId)){
            $data->category = $data->category->where('instrumentId',$req->instrumentId);
            $data->guitarSeries = $data->guitarSeries->where('instrumentId',$req->instrumentId);
            // Instument data
            $data->instrument = Instrument::where('id',$req->instrumentId)->first();
        }
        if(!empty($req->categoryId)){
            $data->guitarSeries = $data->guitarSeries->where('categoryId',$req->categoryId);
        }
        if(!empty($req->difficulty)){
            $data->guitarSeries = $data->guitarSeries->where('difficulty',$req->difficulty);
        }
        $data->category = $data->category->get();
        $data->guitarSeries = $data->guitarSeries->get();
        foreach($data->guitarSeries as $key => $guitar){
            $guitar->userPurchased = false;
            if($user){
                $checkPurchase = UserProductLessionPurchase::where('userId',$user->id)->where('productSeriesId',$guitar->id)->first();
                if($checkPurchase){
                    $guitar->userPurchased = true;
                }
            }
        }
        return view('front.product.series',compact('data','req'));
    }

    public function browseProductSeriesAll(Request $req)
    {
        $data = (object)[];$user = auth()->user();
        $data->instrument = Instrument::select('*')->get();
        $data->category = Category::select('*')->get();
        $data->tutor = User::where('user_type',2)->get();
        $data->guitarSeries = ProductSeries::select('*');
        if(!empty($req->instrument)){
            $data->guitarSeries = $data->guitarSeries->where('instrumentId',$req->instrument);
        }
        if(!empty($req->category)){
            $data->guitarSeries = $data->guitarSeries->where('categoryId',$req->category);
        }
        if(!empty($req->difficulty)){
            $data->guitarSeries = $data->guitarSeries->where('difficulty',$req->difficulty);
        }
        if(!empty($req->tutor)){
            $data->guitarSeries = $data->guitarSeries->where('createdBy',$req->tutor);
        }
        $data->guitarSeries = $data->guitarSeries->paginate(12);
        foreach($data->guitarSeries as $key => $guitar){
            $guitar->userPurchased = false;
            if($user){
                $checkPurchase = UserProductLessionPurchase::where('userId',$user->id)->where('productSeriesId',$guitar->id)->first();
                if($checkPurchase){
                    $guitar->userPurchased = true;
                }
            }
        }
        return view('front.product.browseAllSeries',compact('data','req'));
    }

    public function browserProductDetails(Request $req,$seriesId)
    {
        $data = ProductSeries::where('id',$seriesId)->first();$user = auth()->user();
        if($data){
            if(!empty($req->difficulty)){
                $data->lession = $data->lession->where('difficulty',$req->difficulty);
            }
            $data->userPurchased = false;
            if($user){
                $checkPurchase = UserProductLessionPurchase::where('userId',$user->id)->where('productSeriesId',$data->id)->first();
                if($checkPurchase){
                    $data->userPurchased = true;
                }
            }
            $data->otherGuitarSeries = ProductSeries::where('id','!=',$data->id)->limit(3)->get();
            foreach($data->otherGuitarSeries as $key => $other){
                $other->userPurchased = false;
                if($user){
                    $checkPurchase = UserProductLessionPurchase::where('userId',$user->id)->where('productSeriesId',$other->id)->first();
                    if($checkPurchase){
                        $other->userPurchased = true;
                    }
                }
            }
            return view('front.product.seriesDetails',compact('data','req'));    
        }
        return errorResponse('Something went wrong please try after sometime');
    }

/************************************* Subscription **************************************/
    public function subscription(Request $req)
    {
        $user = auth()->user();
        $data = (object)[];
        $data->subscription = SubscriptionPlan::get();
        foreach($data->subscription as $key => $subscription){
            $subscription->userSubscribed = false;
            if($user){
                $checkSubscription = UserSubscription::where('userId',$user->id)->where('subscriptionId',$subscription->id)->first();
                if($checkSubscription){
                    $subscription->userSubscribed = true;
                }
            }
        }
        return view('front.subscription',compact('data'));
    }

    public function afterPaymentSubscription(Request $req,$subscriptionId)
    {
        if(!empty($req->transactionId)){
            $transaction = Transaction::where('id',$req->transactionId)->first();
            if($transaction){
                $subscription = SubscriptionPlan::where('id',$subscriptionId)->first();
                if($subscription){
                    $userSubscription = new UserSubscription();
                        $userSubscription->userId = auth()->user()->id;
                        $userSubscription->subscriptionId = $subscription->id;
                        $userSubscription->transactionId = $transaction->id;
                        $userSubscription->valid_till = date('Y-m-d',strtotime('+'.$subscription->valid_for.' month'));
                    $userSubscription->save();
                    return redirect(route('subscription.purchase.thankyou').'?userSubscriptionId='.$userSubscription->id);
                }else{
                    $message = 'Invalid Subscription Plan Selected';
                }
            }else{
                $message = 'Invalid Transaction Id';
            }
        }else{
            $message = 'Transaction Id must be There';
        }
        return response()->json(['error' => true,'message' => $message]);
    }

    public function thankyouSubscriptionPurchase(Request $req)
    {
        if(!empty($req->userSubscriptionId)){
            $purchaseSubscription = UserSubscription::where('id',$req->userSubscriptionId)->where('userId',auth()->user()->id)->first();
            if($purchaseSubscription){
                return view('payment.razorpay.subscription.thankyou',compact('purchaseSubscription'));
            }
        }
        return response()->json(['error' => true,'message' => 'Invalid Request Found']);
    }


/************************************* product Series and Their Lession Purchase **************************************/
    
    public function afterPaymentProductSeries(Request $req,$seriesId)
    {
        if(!empty($req->transactionId)){
            $transaction = Transaction::where('id',$req->transactionId)->first();
            if($transaction){
                $productSeries = ProductSeries::where('id',$seriesId)->first();
                if($productSeries){
                    foreach ($productSeries->lession as $key => $lession){
                        $newLessionPurchase = new UserProductLessionPurchase();
                            $newLessionPurchase->userId = auth()->user()->id;
                            $newLessionPurchase->productSeriesId = $productSeries->id;
                            $newLessionPurchase->productSeriesLessionId = $lession->id;
                            $newLessionPurchase->transactionId = $transaction->id;
                        $newLessionPurchase->save();
                    }
                    return redirect(route('product.series.purchase.thankyou').'?productSeriesId='.$productSeries->id);
                }else{
                    $message = 'Invalid Product Series Plan Selected';
                }
            }else{
                $message = 'Invalid Transaction Id';
            }
        }else{
            $message = 'Transaction Id must be There';
        }
        return response()->json(['error' => true,'message' => $message]);
    }

    public function afterPaymentGuitarSeriesLession(Request $req,$lessionId)
    {
        if(!empty($req->transactionId)){
            $transaction = Transaction::where('id',$req->transactionId)->first();
            if($transaction){
                $productLession = ProductSeriesLession::where('id',$lessionId)->first();
                if($productLession){
                        $newLessionPurchase = new UserProductLessionPurchase();
                            $newLessionPurchase->userId = auth()->user()->id;
                            $newLessionPurchase->productSeriesId = $productLession->productSeriesId;
                            $newLessionPurchase->productSeriesLessionId = $productLession->id;
                            $newLessionPurchase->transactionId = $transaction->id;
                        $newLessionPurchase->save();
                    return redirect(route('product.series.purchase.thankyou').'?productSeriesId='.$productLession->productSeriesId.'&productLessionId='.$productLession->id);
                }else{
                    $message = 'Invalid Product Series Plan Selected';
                }
            }else{
                $message = 'Invalid Transaction Id';
            }
        }else{
            $message = 'Transaction Id must be There';
        }
        return response()->json(['error' => true,'message' => $message]);
    }

    public function thankyouProductSeries(Request $req)
    {
        $purchaseSeries = UserProductLessionPurchase::select('*')->where('userId',auth()->user()->id);
        if(!empty($req->productSeriesId)){
            $purchaseSeries = $purchaseSeries->where('productSeriesId',$req->productSeriesId);
        }
        if(!empty($req->productLessionId)){
            $purchaseSeries = $purchaseSeries->where('productSeriesLessionId',$req->productLessionId);
        }
        $purchaseSeries = $purchaseSeries->get();
        if(count($purchaseSeries) > 0){
            return view('payment.razorpay.guitar.thankyou',compact('purchaseSeries'));
        }
        return response()->json(['error' => true,'message' => 'Invalid Request Found']);
    }

/************************* Guitar Series and Their Lession Purchase END *****************************/

    public function userSubscription(Request $req)
    {
        $user = auth()->user();
        return view('auth.user.subscription',compact('user'));
    }

    public function userProductLessionPurchaseList()
    {
        $user = auth()->user();
        return view('auth.user.productLessionPurchaseList',compact('user'));
    }

    // Explote Tutor
    public function exploreTutor(Request $req,$tutorId = 0)
    {
        $tutor = User::where('user_type',2);
        if( base64_decode($tutorId) != 0){ // if Indivisual tutor Calls
            $tutorId = base64_decode($tutorId);
            $tutor = $tutor->where('id',$tutorId)->first();
            if($tutor){
                foreach($tutor->product_series as $key => $product){
                    $product->userPurchased = false;
                    if($user = $req->user()){
                        $checkPurchase = UserProductLessionPurchase::where('userId',$user->id)->where('productSeriesId',$product->id)->first();
                        if($checkPurchase){
                            $product->userPurchased = true;
                        }
                    }
                }
                return view('tutor.display.invisualProfile',compact('tutor'));
            }
            return back()->with('Errors','Invalid Tutor Selected');
        } // when Tutor list will call
        $tutor = $tutor->paginate(12);
        return view('tutor.display.profileList',compact('tutor'));
    }

    public function subscribeEmail(Request $req)
    {
        $req->validate([
            'email' => 'required|email|string|max:150',
            'agree' => 'nullable|in:1,0',
        ]);
        $email = EmailSubscription::where('email',$req->email)->first();
        if(!$email){
            $email = new EmailSubscription();
            $email->email = $req->email;
            $email->agree = ($req->agree) ? 1 : 0;
        }
        if(auth()->user()){
            $email->createdBy = auth()->user()->id;
        }
        $email->status = 1;
        $email->save();
        $req->session()->put('email_subscribe', '1');
        return back()->with('Success','Email Subscribed Success');
    }

    public function unSubscribeEmail(Request $req)
    {
        $req->validate([
            'email' => 'required|email|string|max:150',
        ]);
        $email = EmailSubscribe::where('email',$req->email)->first();
        if($email){
            $email->delete();
        }
        return successResponse('Email Un-Subscribed Success');
    }

    public function ratingTutor(Request $req)
    {
        $rules = [
            'tutorId' => 'required|min:1|numeric',
            'ratedUserId' => 'required|min:1|numeric',
            'comment' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            if($req->tutorId == $req->ratedUserId){
                return errorResponse('You can`t rate your self');
            }
            $newRating = new UserRating();
            $newRating->userId = $req->tutorId;
            $newRating->ratedUserId = $req->ratedUserId;
            $newRating->comment = $req->comment;
            $newRating->rating = $req->rating;
            $newRating->save();
            $newRating->posted_date = date('M d, Y H:i A');
            $newRating->rated_user_details;
            return successResponse('Rating Post Success',$newRating);
        }
        return errorResponse($validator->errors()->first());
    }

    public function termsAndCondition(Request $req)
    {
        $term_condition = Setting::where('key','termsCondition')->first();
        return view('front.policy.terms_condition',compact('term_condition'));
    }

    public function privacyPolicy(Request $req)
    {
        $privacy = Setting::where('key','privacyPolicy')->first();
        return view('front.policy.privacyPolicy',compact('privacy'));
    }

    public function refundPolicy(Request $req)
    {
        $refundPolicy = Setting::where('key','refundPolicy')->first();
        return view('front.policy.refundPolicy',compact('refundPolicy'));
    }

    public function howItWorks(Request $req)
    {
        $howitworkMain = Setting::where('key','howitworkMain')->first();
        return view('front.policy.howItWorks',compact('howitworkMain'));
    }

    // About Us
    public function aboutus(Request $req)
    {
        $data = (object)[];
        $data->aboutus = Setting::where('key','aboutus')->first();
        return view('front.about-us',compact('data'));
    }

    public function testimonialsList(Request $req)
    {
        $data = (object)[];$sorting = 'desc';
        $data->testimonials = Testimonial::select('*');
        if($req->sorting){
            $sorting = $req->sorting;
        }
        $data->testimonials = $data->testimonials->orderBy('id',$sorting)->get();
        return view('front.testimonialList',compact('data','req'));
    }

    public function exploreInstruments(Request $req)
    {
        $data = (object)[];$sorting = 'desc';
        $data->instruments = Instrument::select('*');
        if($req->sorting){
            $sorting = $req->sorting;
        }
        $data->instruments = $data->instruments->orderBy('id',$sorting)->get();
    return view('front.exploreInstrument',compact('data','req'));
    }
}
