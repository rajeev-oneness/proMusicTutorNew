<?php

function successResponse($msg = '', $data = [], $status = 200)
{
	return response()->json(['error' => false, 'status' => $status, 'message' => $msg, 'data' => $data]);
}

function errorResponse($msg = '', $data = [], $status = 200)
{
	return response()->json(['error' => true, 'status' => $status, 'message' => $msg, 'data' => $data]);
}

function razorpayPaymentForm($price = 1, $redirectURL = '')
{
	$key = env('RAZORPAY_KEY');
	$route = route('razorpay.payment.store');
	$token = csrf_field();
	$logoImage = asset('defaultImages/logo.jpeg');
	$dataAmount = $price * 100;
	echo "
	        <form action='$route' method='POST'>
	            $token
	            <input type='hidden' name='redirectURL' value='$redirectURL'>
                <script src='https://checkout.razorpay.com/v1/checkout.js'
                        data-key='$key'
                        data-amount='$dataAmount'
                        /****data-buttontext='Pay $price INR'****/
                        data-name='Pro Music Tutor'
                        data-description='All downloads available in FULL HD or stream'
                        data-image='$logoImage'
                        /*data-prefill.name=''
                        data-prefill.email=''*/
                        data-theme.color='#ff7529'>
                </script>
            </form>";
}

function sendMail($data, $templateName, $to, $subject)
{
	$newMail = new \App\Models\EmailLog();
	$newMail->from = 'onenesstechsolution@gmail.com';
	$newMail->to = $to;
	$newMail->subject = $subject;
	$newMail->view_file = $templateName;
	$newMail->payload = json_encode($data);
	$newMail->save();
	Mail::send('emails/' . $templateName, $data, function ($message) use ($data, $to, $subject) {
		$message->to($to, $data['name'])->subject($subject);
		$message->from('onenesstechsolution@gmail.com', 'Pro Music Tutor');
	});
}

function imageUpload($image, $folder = 'image')
{
	$random = randomGenerator();
	$image->move('upload/' . $folder . '/', $random . '.' . $image->getClientOriginalExtension());
	$imageurl = 'upload/' . $folder . '/' . $random . '.' . $image->getClientOriginalExtension();
	return $imageurl;
}

function generateUniqueAlphaNumeric($length = 8)
{
	$random_string = '';
	for ($i = 0; $i < $length; $i++) {
		$number = random_int(0, 36);
		$character = base_convert($number, 10, 36);
		$random_string .= $character;
	}
	return $random_string;
}

function referralCodeGenerate()
{
	$newReferralCode = generateUniqueAlphaNumeric(8);
	$referralMatch = \App\Models\User::where('referral_code', $newReferralCode)->withTrashed()->first();
	if (!$referralMatch) {
		return strtoupper($newReferralCode);
	}
	return $this->generateUniqueReferral();
}

function zeroGoesToBlank($value)
{
	if ($value == 0) {
		return '';
	}
	return $value;
}

function emptyCheck($string, $date = false)
{
	if ($date) {
		return !empty($string) ? $string : '0000-00-00';
	}
	return !empty($string) ? $string : '';
}

function randomGenerator()
{
	return uniqid() . '' . date('ymdhis') . '' . uniqid();
}

function moneyFormat($amount)
{
	$amount = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount);
	return $amount;
}

function words($string, $words = 100)
{
	return Str::limit($string, $words);
}

function calculateLessionPrice($seriesObject = [], $currency = 'usd',$priceFor='lessionWise')
{
	$totalPrice = 0;
	// if($priceFor == 'lessionWise'){
	// 	foreach ($seriesObject->lession as $lession) {
	// 		if ($currency == 'usd') {
	// 			$totalPrice += $lession->price_usd;
	// 		} elseif ($currency == 'eur') {
	// 			$totalPrice += $lession->price_euro;
	// 		} else {
	// 			$totalPrice += $lession->price_gbp;
	// 		}
	// 	}	
	// }elseif($priceFor == 'seriesWise'){
		if ($currency == 'usd') {
			$totalPrice += $seriesObject->price_usd;
		} elseif ($currency == 'eur') {
			$totalPrice += $seriesObject->price_euro;
		} else {
			$totalPrice += $seriesObject->price_gbp;
		}
	// }
	return $totalPrice;
}

function calculateLessionPriceOLD($lessionObject = [], $currency = 'usd')
{
	$totalPrice = 0;
	foreach ($lessionObject as $lession) {
		if ($currency == 'usd') {
			$totalPrice += $lession->price_usd;
		} elseif ($currency == 'eur') {
			$totalPrice += $lession->price_euro;
		} else {
			$totalPrice += $lession->price_gbp;
		}
	}
	return $totalPrice;
}

function getSumOfPoints($userPoints)
{
	$totalPoint = 0;
	foreach ($userPoints as $getPoint) {
		$totalPoint += $getPoint->points;
	}
	return $totalPoint;
}

function userLessionPurchased($lession_data = [])
{
	$return = false;
	$check = \App\Models\UserProductLessionPurchase::where('userId', auth()->user()->id)->where('productSeriesLessionId', $lession_data->id)->where('productSeriesId', $lession_data->productSeriesId)->first();
	if ($check) {
		$return = true;
	}
	return $return;
}

function getPurchasedLessionUnderSeries($seriesInfo){
	$lession =  \App\Models\UserProductLessionPurchase::where('userId', $seriesInfo->userId)->where('productSeriesId', $seriesInfo->productSeriesId)->where('transactionId', $seriesInfo->transactionId)->where('type_of_product',$seriesInfo->type_of_product);
	$lession = $lession->where('offerId',$seriesInfo->offerId);
	$lession = $lession->get();
	return $lession;
}

function getPurchaseSeriesUnderOffer($offer)
{
	return \App\Models\UserProductLessionPurchase::where('userId', $offer->userId)->where('offerId', $offer->offerId)->where('transactionId', $offer->transactionId)->where('type_of_product','offer')->groupBy('productSeriesId')->get();
}

function currencySymbol($type = '')
{
	$view = '$';
	switch ($type) {
		case 'gbp':$view = '£';break;
		case 'usd':$view = '$';break;
		case 'eur':$view = '€';break;
		case 'euro':$view = '€';break;
		default:$view = '$';break;
	}
	return $view;
}

function createSlug($str, $delimiter = '-')
{
	$slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
	return $slug;
}
