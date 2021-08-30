<?php 

	function razorpayPaymentForm($price = 1,$redirectURL=''){
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

	function imageUpload($image,$folder='image')
	{
		$random = randomGenerator();
		$image->move('upload/'.$folder.'/',$random.'.'.$image->getClientOriginalExtension());
        $imageurl = 'upload/'.$folder.'/'.$random.'.'.$image->getClientOriginalExtension();
        return $imageurl;
	}
	
	function successResponse($msg='',$data=[],$status=200)
	{
		return response()->json(['error'=>false,'status'=>$status,'message'=>$msg,'data'=>$data]);
	}

	function errorResponse($msg='',$data=[],$status=200)
	{
		return response()->json(['error'=>true,'status'=>$status,'message'=>$msg,'data'=>$data]);
	}

	function emptyCheck($string,$date=false)
	{
		if($date){
			return !empty($string) ? $string : '0000-00-00';
		}
		return !empty($string) ? $string : '';
	}

	function randomGenerator()
	{
		return uniqid().''.date('ymdhis').''.uniqid();
	}

	function moneyFormat($amount)
	{
		$amount = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount);
		return $amount;
	}

	function words($value, $words = 100, $end = '...')
    {
        return Str::words($value, $words, $end);
    }
    
	function generateUniqueAlphaNumeric($length = 7)
    {
    	$random_string = '';
    	for($i = 0; $i < $length; $i++) {
    		$number = random_int(0, 36);
    		$character = base_convert($number, 10, 36);
    		$random_string .= $character;
    	}
    	return $random_string;
    }

    function calculateLessionPrice($lessionObject=[]){
    	$totalPrice = 0;
    	foreach($lessionObject as $lession){
    		$totalPrice += $lession->price;
    	}
    	return $totalPrice;
    }

    function getSumOfPoints($userPoints){
    	$totalPoint = 0;
    	foreach($userPoints as $getPoint){
    		$totalPoint += $getPoint->points;
    	}
    	return $totalPoint;
    }

    function userLessionPurchased($lession_data = [])
    {
    	$return = false;
    	$check = \App\Models\UserGuitarLessionPurchase::where('userId',auth()->user()->id)->where('guitarSeriesLessionId',$lession_data->id)->where('guitarSeriesId',$lession_data->guitarSeriesId)->first();
    	if($check){
    		$return = true;
    	}
    	return $return;	
    }


 ?>