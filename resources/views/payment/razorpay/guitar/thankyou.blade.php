@extends('layouts.master')
@section('title','Thankyou Subscription')
@section('content')
	<div class="thank-you">
        <div class="container">
            <div class="thamk-youmiddle">
                <img src="{{asset('design/img/logopro.png')}}" alt="">
                <div class="area-thank">
                    <h2>Thank You</h2>
                    <h3>For <span>Purchase</span> Product Series</h3>
                </div>
                <p>
                	<ul>
                		<li>Your Purchase Product Series</li>
                		<ul>
                			<?php $productSeriesName = '';$transactionId = '';?>
	                		@foreach($purchaseSeries as $purchaseLession)

	                		<?php 
								$productSeriesName = $purchaseLession->product_series->title;
								$transactionId = $purchaseLession->transaction->transactionId;
	                		?>
		                	@break
	                		@endforeach
	                		<li>Product Series : {{$productSeriesName}}</li>
	                		<li>Transaction Id : {{$transactionId}}</li>
	                		<li><a href="{{route('user.guitar')}}">View your Purchase</a></li>
                		</ul>
                	</ul>
                </p>
            </div>
        </div>
    </div>
@endsection




