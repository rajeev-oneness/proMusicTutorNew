@extends('layouts.master')
@section('title','Thankyou Subscription')
@section('content')
	<div class="thank-you">
        <div class="container">
            <div class="thamk-youmiddle">
                <img src="{{asset('design/img/logopro.png')}}" alt="">
                <div class="area-thank">
                    <h2>Thank You</h2>
                    <h3>For <span>Purchase</span> Guitar Series</h3>
                </div>
                <p>
                	<ul>
                		<li>Your Purchase Guitar Series</li>
                		<ul>
                			<?php $guitarSeriesName = '';$transactionId = '';?>
	                		@foreach($purchaseGuitarSeries as $lession)
	                		<?php 
								$guitarSeriesName = $lession->guitar_series->title;
								$transactionId = $lession->transaction->transactionId;
	                		?>
		                	@break
	                		@endforeach
	                		<li>Guitar Series : {{$guitarSeriesName}}</li>
	                		<li>Transaction Id : {{$transactionId}}</li>
	                		<li><a href="{{route('user.guitar')}}">View your Purchase</a></li>
                		</ul>
                	</ul>
                </p>
            </div>
        </div>
    </div>
@endsection




