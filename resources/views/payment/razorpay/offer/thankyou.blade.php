@extends('layouts.master')
@section('title','Thankyou Offer')
@section('content')
	<div class="thank-you">
        <div class="container">
            <div class="thamk-youmiddle">
                <img src="{{asset('design/img/logopro.png')}}" alt="">
                <div class="area-thank">
                    <h2>Thank You</h2>
                    <h3>For <span>Purchasing</span> Offer Series Bundle</h3>
                </div>
                <p>
                	<ul>
                		<li>Your Purchase Product Lessons</li>
                		<ol>
                			<?php $productSeriesName = '';$transactionId = '';?>
	                		@foreach($purchaseOffer as $productSeries)
								<li>Lesson name : {{$productSeries->product_series_lession->title}}</li>
	                		@endforeach
                		</ul>
						<li><a href="{{route('user.instrument.lession')}}">View your Purchase</a></li>
                	</ul>
                </p>
            </div>
        </div>
    </div>
@endsection




