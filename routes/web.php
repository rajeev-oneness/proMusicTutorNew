<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CrudController;

Route::get('/', [DefaultController::class, 'welcome'])->name('welcome');
Route::get('administrator',[LoginController::class,'adminLoginView'])->name('admin.login');
Route::get('explore/instrument', [DefaultController::class, 'exploreInstruments'])->name('explore.instrument');
Route::any('explore/tutor/{tutorId?}', [DefaultController::class, 'exploreTutor'])->name('explore.tutor');
Route::get('explore/testimonials', [DefaultController::class, 'testimonialsList'])->name('explore.testimonials');

Route::get('about-us', [DefaultController::class, 'aboutus'])->name('welcome.aboutus');
Route::any('product/series', [DefaultController::class, 'browserProduct'])->name('product.series');
Route::any('browse/product/series', [DefaultController::class, 'browseProductSeriesAll'])->name('browse.product.series');
Route::any('product/series/{seriesId}/details', [DefaultController::class, 'browserProductDetails'])->name('product.series.details');
Route::get('subscription/plan', [DefaultController::class, 'subscription'])->name('subscription.plan');
Route::post('email/subscribe', [DefaultController::class, 'subscribeEmail'])->name('email.subscribe');
Route::get('email/unsubscribe', [DefaultController::class, 'unSubscribeEmail'])->name('email.unsubscribe');

Route::get('how-it-works', [DefaultController::class, 'howItWorks'])->name('howitworks');
Route::get('faq', [DefaultController::class, 'faq'])->name('faq');
Route::get('contact-us', [DefaultController::class, 'contactUsFront'])->name('contact.us');
Route::post('contact-us', [DefaultController::class, 'contactUsFrontSave'])->name('contactus.save');
Route::get('terms-and-condition', [DefaultController::class, 'termsAndCondition'])->name('terms&condition');
Route::get('privacy/policy', [DefaultController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('refund/policy', [DefaultController::class, 'refundPolicy'])->name('policy.refund');

Auth::routes(['logout' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::any('logout', [HomeController::class, 'logout'])->name('logout');

// SOCIALITE SIGN-IN
Route::get('sign-in/{socialite}', [LoginController::class, 'socialiteLogin'])->name('socialite.login');
Route::get('sign-in/{socialite}/redirect', [LoginController::class, 'socialiteLoginRedirect'])->name('socialite.login.redirect');

// OFFER ROUTES
Route::any('offers', [DefaultController::class, 'offersList'])->name('front.offers');
Route::any('offers/{offerId}/detail', [DefaultController::class, 'offerDetail'])->name('front.offers.detail');

//WISHLIST ROUTE
Route::post('/wishlists', [DefaultController::class, 'wishlistToggle'])->name('front.wishlist.toggle');

// Common Auth Routes
Route::group(['middleware' => 'auth'], function () {
	Route::get('user/profile', [HomeController::class, 'userProfile'])->name('user.profile');
	Route::post('user/profile', [HomeController::class, 'userProfileSave'])->name('user.profile.save');
	Route::post('user/change/password', [HomeController::class, 'updateUserPassword'])->name('user.changepassword.save');
	Route::get('user/points', [HomeController::class, 'userPoints'])->name('user.points');
	Route::post('tutor/rating/post', [DefaultController::class, 'ratingTutor'])->name('tutor.rating.post');
	// Subscription Purchase
	Route::get('after/purchase/subscription/{subscriptionId}', [DefaultController::class, 'afterPaymentSubscription'])->name('after.purchase.subscribe');
	Route::get('subscription/purchase/successfull', [DefaultController::class, 'thankyouSubscriptionPurchase'])->name('subscription.purchase.thankyou');
	// Series Purchase
	Route::get('after/purchase/product/series/{seriesId}', [DefaultController::class, 'afterPaymentProductSeries'])->name('after.purchase.guitar_series');
	Route::get('product/series/purchase/successfull', [DefaultController::class, 'thankyouProductSeries'])->name('product.series.purchase.thankyou');
	// OFFER SERIES PURCHASE
	Route::get('after/purchase/offer/{offerId}/series', [DefaultController::class, 'afterPaymentOfferSeries'])->name('after.purchase.offer_series');
	Route::get('offer/series/purchase/successfull', [DefaultController::class, 'thankyouOfferSeries'])->name('offer.series.purchase.thankyou');
	// Lession Purchase
	Route::get('after/purchase/guitar/series/lession/{lessionId}', [DefaultController::class, 'afterPaymentGuitarSeriesLession'])->name('after.purchase.guitar_lession_series');
	/**************************** Purchase From Cart ****************************/
	Route::get('after/checkout/from/cart/{cartinfo}', [CartController::class, 'afterPaymentCartCheckout'])->name('after.checkout.from_cart');
	Route::get('user/cart/purchase/success/{cartinfo}',[CartController::class,'thankyouCartPurchase'])->name('cart.purchase.thankyou');
	/**************************** User Subscription ****************************/
	Route::get('user/subscription', [DefaultController::class, 'userSubscription'])->name('user.subscription');
	Route::get('user/instrument/lession', [DefaultController::class, 'userProductLessionPurchaseList'])->name('user.instrument.lession');
	/**************************** Razorpay Payment Route ****************************/
	Route::post('razorpay/payment', [PaymentController::class, 'storerazorePayPayment'])->name('razorpay.payment.store');
	/**************************** Cart Info ****************************/
	Route::get('user/cart-info',[CartController::class,'getUserCart'])->name('user.cart.info');
	Route::post('user/cart-info/add_or_remove',[CartController::class,'addOrRemoveCartProduct'])->name('user.cartinfo.add_or_remove');
	Route::post('user/cart-info/update_to_same_currency',[CartController::class,'convertCartToSameCurrency'])->name('user.cartinfo.change_to_same_currency');
	Route::get('notification',[CrudController::class,'getUserNotification'])->name('user.notification.get');
	Route::post('notification/mark_as_read',[CrudController::class,'notificationMarkAsReadOrUnRead'])->name('notification.markasread');
});

// Stripe Payment Route
Route::post('stripe/payment/form_submit', [PaymentController::class, 'stripePostForm_Submit'])->name('stripe.payment.form_submit');
Route::get('payment/successfull/thankyou/{stripeTransactionId}', [PaymentController::class, 'thankyouPayment'])->name('payment.successfull.thankyou');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
	require 'custom/admin.php';
});

Route::group(['prefix' => 'tutor', 'middleware' => 'tutor'], function () {
	require 'custom/tutor.php';
});

Route::group(['prefix' => 'user', 'middleware' => 'user'], function () {
	require 'custom/user.php';
});

Route::get('payment', [TestController::class, 'payment'])->name('payment');
Route::get('cancel', [TestController::class, 'cancel'])->name('payment.cancel');
Route::get('payment/success', [TestController::class, 'success'])->name('payment.success');

Route::get('twocheckout',[TestController::class,'checkoutTwo'])->name('payment.twocheckout');
Route::get('twocheckout/callback',[TestController::class,'callbackCheckoutTwo'])->name('payment.callbackCheckoutTwo.callback');