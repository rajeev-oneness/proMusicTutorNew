@extends('layouts.master')
@section('title','Thankyou Subscription')
@section('content')
	<div class="thank-you bg-light">
        <div class="container">
            <div class="row m-0 align-items-lg-center justify-content-between">
                <div class="col-12 col-md-6 p-0">
                    <div class="area-thank">
                        <h2>Thank You</h2>
                        <h3>For <span>Purchase</span> Product Series</h3>
                        <p class="mb-2"><b>Your Purchase Product Series</b></p>
                		<ul>
                			<?php $productSeriesName = '';$transactionId = '';?>
                    		@foreach($purchaseSeries as $purchaseLession)
    	                		<?php 
    								$productSeriesName = $purchaseLession->product_series->title;
    								$transactionId = $purchaseLession->transaction->transactionId;
    	                		?>
    	                	@break
                    		@endforeach
                    		<li>Product Series : <span>{{$productSeriesName}}</span></li>
                    		<li>Transaction Id : <span>{{$transactionId}}</span></li>
                    		<li><a href="{{route('user.instrument.lession')}}">View your Purchase</a></li>
                		</ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 p-0">
                    <img src="{{asset('design/img/thank_you_img.png')}}" alt="" class="w-100">
                </div>
            </div>
        </div>
    </div>
@endsection




