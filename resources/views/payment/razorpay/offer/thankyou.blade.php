@extends('layouts.master')
@section('title','Thankyou Offer')
@section('content')
	<div class="thank-you">
        <div class="container">
            <div class="row m-0 align-items-lg-center justify-content-between">
                <div class="col-12 col-md-6 p-0">
                    <div class="area-thank">
                        <h2>Thank You</h2>
                        <h3>For <span>Purchasing</span> Offer Series Bundle</h3>
                        <p class="mb-2"><b>Your Purchase Product Lessons</b></p>
                        <ul>
                            <?php $productSeriesName = '';$transactionId = '';?>
	                		@foreach($purchaseOffer as $productSeries)
								<li>Lesson name : <span>{{$productSeries->product_series_lession->title}}</span></li>
	                		@endforeach
	                		<li><a href="{{route('user.instrument.lession')}}">View your Purchase</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 p-0">
                    <img src="{{asset('design/img/thank_you_img.png')}}" alt="" class="w-100">
                </div>
            </div>
            <!--<div class="thamk-youmiddle">
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
            </div>-->
        </div>
    </div>
@endsection




