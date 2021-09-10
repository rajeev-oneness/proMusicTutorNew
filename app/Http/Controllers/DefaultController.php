<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,App\Models\ContactUs;
use App\Models\EmailSubscription,App\Models\Faq,App\Models\User;
use App\Models\Testimonial,App\Models\Instrument,App\Models\Category;
use App\Models\ProductSeries,App\Models\SubscriptionPlan;
use App\Models\Transaction,App\Models\UserSubscription;
use App\Models\UserProductLessionPurchase,App\Models\ProductSeriesLession;
use App\Models\Setting;

class DefaultController extends Controller
{
    public function welcome(Request $req)
    {
        $data = (object)[];
        $data->faq = Faq::get();
        $data->tutor = User::where('user_type',2)->orderBy('id','ASC')->limit(10)->get();
        $data->testimonial = Testimonial::where('id',1)->get();
        $data->instrument = Instrument::limit(2)->get();
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

    public function browserGuitar(Request $req)
    {
        $data = (object)[];$user = auth()->user();
        $data->category = Category::get();
        $guitarSeries = ProductSeries::select('*');
        if(!empty($req->categoryId)){
            $guitarSeries = $guitarSeries->where('categoryId',$req->categoryId);
        }
        $guitarSeries = $guitarSeries->get();
        foreach($guitarSeries as $key => $guitar){
            if($user){
                $checkPurchase = UserProductLessionPurchase::where('userId',$user->id)->where('productSeriesId',$guitar->id)->first();
                if($checkPurchase){
                    $guitar->userPurchased = true;
                }else{
                    $guitar->userPurchased = false;
                }
            }else{
                $guitar->userPurchased = false;
            }
        }
        $data->guitarSeries = $guitarSeries;
        return view('front.product.series',compact('data'));
    }

    public function browserGuitarDetails(Request $req,$seriesId)
    {
        $user = auth()->user();
        $data = ProductSeries::where('id',$seriesId)->first();
        if($data){
            if($user){
                $checkPurchase = UserProductLessionPurchase::where('userId',$user->id)->where('productSeriesId',$data->id)->first();
                if($checkPurchase){
                    $data->userPurchased = true;
                }
            }
            $data->otherGuitarSeries = ProductSeries::where('id','!=',$seriesId)->limit(3)->get();
            foreach($data->otherGuitarSeries as $key => $other){
                if($user){
                    $checkPurchase = UserProductLessionPurchase::where('userId',$user->id)->where('productSeriesId',$other->id)->first();
                    if($checkPurchase){
                        $other->userPurchased = true;
                    }
                }
            }
            return view('front.product.seriesDetails',compact('data'));    
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
            if($user){
                $checkSubscription = UserSubscription::where('userId',$user->id)->where('subscriptionId',$subscription->id)->first();
                if($checkSubscription){
                    $subscription->userSubscribed = true;
                }else{
                    $subscription->userSubscribed = false;
                }
            }else{
                $subscription->userSubscribed = false;
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
    
    public function afterPaymentGuitarSeries(Request $req,$seriesId)
    {
        if(!empty($req->transactionId)){
            $transaction = Transaction::where('id',$req->transactionId)->first();
            if($transaction){
                $guitarSeries = ProductSeries::where('id',$seriesId)->first();
                if($guitarSeries){
                    foreach ($guitarSeries->lession as $key => $lession){
                        $newLessionPurchase = new UserProductLessionPurchase();
                            $newLessionPurchase->userId = auth()->user()->id;
                            $newLessionPurchase->productSeriesId = $guitarSeries->id;
                            $newLessionPurchase->productSeriesLessionId = $lession->id;
                            $newLessionPurchase->transactionId = $transaction->id;
                        $newLessionPurchase->save();
                    }
                    return redirect(route('guitar.series.purchase.thankyou').'?guitarSeriesId='.$guitarSeries->id);
                }else{
                    $message = 'Invalid Guitar Series Plan Selected';
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
                $guitarLession = ProductSeriesLession::where('id',$lessionId)->first();
                if($guitarLession){
                        $newLessionPurchase = new UserProductLessionPurchase();
                            $newLessionPurchase->userId = auth()->user()->id;
                            $newLessionPurchase->productSeriesId = $guitarLession->productSeriesId;
                            $newLessionPurchase->productSeriesLessionId = $guitarLession->id;
                            $newLessionPurchase->transactionId = $transaction->id;
                        $newLessionPurchase->save();
                    return redirect(route('guitar.series.purchase.thankyou').'?guitarSeriesId='.$guitarLession->productSeriesId.'&guitarLessionId='.$guitarLession->id);
                }else{
                    $message = 'Invalid Guitar Series Plan Selected';
                }
            }else{
                $message = 'Invalid Transaction Id';
            }
        }else{
            $message = 'Transaction Id must be There';
        }
        return response()->json(['error' => true,'message' => $message]);
    }

    public function thankyouGuitarSeries(Request $req)
    {
        $purchaseGuitarSeries = UserProductLessionPurchase::select('*')->where('userId',auth()->user()->id);
        if(!empty($req->guitarSeriesId)){
            $purchaseGuitarSeries = $purchaseGuitarSeries->where('guitarSeriesId',$req->guitarSeriesId);
        }
        if(!empty($req->guitarLessionId)){
            $purchaseGuitarSeries = $purchaseGuitarSeries->where('guitarSeriesLessionId',$req->guitarLessionId);
        }
        $purchaseGuitarSeries = $purchaseGuitarSeries->get();
        if(count($purchaseGuitarSeries) > 0){
            return view('payment.razorpay.guitar.thankyou',compact('purchaseGuitarSeries'));
        }
        return response()->json(['error' => true,'message' => 'Invalid Request Found']);
    }

/************************* Guitar Series and Their Lession Purchase END *****************************/

    public function userSubscription(Request $req)
    {
        $user = auth()->user();
        return view('auth.user.subscription',compact('user'));
    }

    public function userGuitarLessionPurchaseList()
    {
        $user = auth()->user();
        return view('auth.user.guitarLessionPurchaseList',compact('user'));
    }


    public function exploreTutor(Request $req,$tutorId = '')
    {
        $tutor = User::where('user_type',2);
        if($tutorId != ''){
            $tutorId = base64_decode($tutorId);
            $tutor = $tutor->where('id',$tutorId);
        }
        $tutor = $tutor->get();
        return response()->json([
            'error' => true,
            'message' => 'This page not created yet',
            'tutor' => $tutor, 
        ]);
        return 'This page not created yet';
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

    public function aboutus(Request $req)
    {
        $data = (object)[];
        $data->aboutus = Setting::where('key','aboutus')->first();
        return view('front.about-us',compact('data'));
    }
}
