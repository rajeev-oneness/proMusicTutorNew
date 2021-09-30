<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[DefaultController::class,'welcome'])->name('welcome');
Route::get('explore/instrument',[DefaultController::class,'exploreInstruments'])->name('explore.instrument');
Route::any('explore/tutor/{tutorId?}',[DefaultController::class,'exploreTutor'])->name('explore.tutor');
Route::get('explore/testimonials',[DefaultController::class,'testimonialsList'])->name('explore.testimonials');

Route::get('about-us',[DefaultController::class,'aboutus'])->name('welcome.aboutus');
Route::any('product/series',[DefaultController::class,'browserProduct'])->name('product.series');
Route::any('browse/product/series',[DefaultController::class,'browseProductSeriesAll'])->name('browse.product.series');
Route::any('product/series/{seriesId}/details',[DefaultController::class,'browserProductDetails'])->name('product.series.details');
Route::get('subscription/plan',[DefaultController::class,'subscription'])->name('subscription.plan');
Route::post('email/subscribe',[DefaultController::class,'subscribeEmail'])->name('email.subscribe');
Route::get('email/unsubscribe',[DefaultController::class,'unSubscribeEmail'])->name('email.unsubscribe');

Route::get('how-it-works',[DefaultController::class,'howItWorks'])->name('howitworks');
Route::get('contact-us',[DefaultController::class,'contactUsFront'])->name('contact.us');
Route::post('contact-us',[DefaultController::class,'contactUsFrontSave'])->name('contactus.save');
Route::get('terms-and-condition',[DefaultController::class,'termsAndCondition'])->name('terms&condition');
Route::get('privacy/policy',[DefaultController::class,'privacyPolicy'])->name('privacy.policy');
Route::get('refund/policy',[DefaultController::class,'refundPolicy'])->name('policy.refund');

Auth::routes(['logout'=>false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::any('logout',[HomeController::class,'logout'])->name('logout');

// SOCIALITE SIGN-IN
Route::get('sign-in/{socialite}',[LoginController::class,'socialiteLogin'])->name('socialite.login');
Route::get('sign-in/{socialite}/redirect',[LoginController::class,'socialiteLoginRedirect'])->name('socialite.login.redirect');

// OFFER ROUTES
Route::any('offers',[DefaultController::class,'offersList'])->name('front.offers');
Route::any('offers/{offerId}/detail',[DefaultController::class,'offerDetail'])->name('front.offers.detail');

//WISHLIST ROUTE
Route::post('/wishlists', [DefaultController::class, 'wishlistToggle'])->name('front.wishlist.toggle');

// Common Auth Routes
Route::group(['middleware' => 'auth'],function(){
	Route::get('user/profile',[HomeController::class, 'userProfile'])->name('user.profile');
	Route::post('user/profile',[HomeController::class, 'userProfileSave'])->name('user.profile.save');
	// Route::get('user/change/password',[HomeController::class, 'index'])->name('user.changepassword');
	Route::post('user/change/password',[HomeController::class, 'updateUserPassword'])->name('user.changepassword.save');
	Route::get('user/points',[HomeController::class, 'userPoints'])->name('user.points');

	Route::post('tutor/rating/post',[DefaultController::class,'ratingTutor'])->name('tutor.rating.post');

	// Subscription Purchase
	Route::get('after/purchase/subscription/{subscriptionId}',[DefaultController::class,'afterPaymentSubscription'])->name('after.purchase.subscribe');
	Route::get('subscription/purchase/successfull',[DefaultController::class,'thankyouSubscriptionPurchase'])->name('subscription.purchase.thankyou');

	// guitar Series Purchase
	Route::get('after/purchase/product/series/{seriesId}',[DefaultController::class,'afterPaymentProductSeries'])->name('after.purchase.guitar_series');
	Route::get('product/series/purchase/successfull',[DefaultController::class,'thankyouProductSeries'])->name('product.series.purchase.thankyou');

	// OFFER SERIES PURCHASE
	Route::get('after/purchase/offer/{offerId}/series',[DefaultController::class,'afterPaymentOfferSeries'])->name('after.purchase.offer_series');
	Route::get('offer/series/purchase/successfull',[DefaultController::class,'thankyouOfferSeries'])->name('offer.series.purchase.thankyou');

	// Guitar Lession Purchase
	Route::get('after/purchase/guitar/series/lession/{lessionId}',[DefaultController::class,'afterPaymentGuitarSeriesLession'])->name('after.purchase.guitar_lession_series');

	Route::get('user/subscription',[DefaultController::class,'userSubscription'])->name('user.subscription');
	Route::get('user/instrument/lession',[DefaultController::class,'userProductLessionPurchaseList'])->name('user.instrument.lession');
	// Razorpay Payment Route
	Route::post('razorpay/payment', [PaymentController::class, 'storerazorePayPayment'])->name('razorpay.payment.store');
});

// Stripe Payment Route
Route::post('stripe/payment/form_submit',[PaymentController::class, 'stripePostForm_Submit'])->name('stripe.payment.form_submit');
Route::get('payment/successfull/thankyou/{stripeTransactionId}',[PaymentController::class, 'thankyouPayment'])->name('payment.successfull.thankyou');

Route::group(['prefix'=>'admin','middleware'=>'admin'],function(){
	require 'custom/admin.php';
});

Route::group(['prefix'=>'tutor','middleware'=>'tutor'],function(){
	require 'custom/tutor.php';
});

Route::group(['prefix'=>'user','middleware'=>'user'],function(){
	require 'custom/user.php';
});


Route::get('payment', [TestController::class,'payment'])->name('payment');
Route::get('cancel', [TestController::class,'cancel'])->name('payment.cancel');
Route::get('payment/success', [TestController::class,'success'])->name('payment.success');