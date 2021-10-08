@extends('layouts.master')
@section('title','Thankyou Subscription')
@section('content')
	<div class="thank-you">
        <div class="container">
            <div class="thamk-youmiddle">
                <img src="{{asset('design/img/logopro.png')}}" alt="">
                <div class="area-thank">
                    <h2>Thank You</h2>
                    <h3>Your product <span>was Successfully Purchased</span> </h3>
                </div>
                <p>
                	<ul>
                		<li>Your Purchase Details</li>
                		<ul>
	                		@foreach($cart as $cartData)
			                	<li>{{strtoupper($cartData->type_of_product)}} : {{words($cartData->product_info->title,20)}}</li>	
	                		@endforeach
	                		
	                		<li>Transaction Id : {{$transaction->transactionId}}</li>
	                		<li><a href="{{route('user.instrument.lession')}}">View your Purchase</a></li>
                		</ul>
                	</ul>
                </p>
            </div>
        </div>
    </div>
@endsection




