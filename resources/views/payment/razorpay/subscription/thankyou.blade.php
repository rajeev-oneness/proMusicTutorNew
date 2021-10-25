@extends('layouts.master')
@section('title','Thankyou Subscription')
@section('content')
	<div class="thank-you">
        <div class="container">
            <div class="row m-0 align-items-lg-center justify-content-between">
                <div class="col-12 col-md-6 p-0">
                    <div class="area-thank">
                        <h2>Thank You</h2>
                        <h3>For <span>Purchase</span> Subscription</h3>
                        <p class="mb-2"><b>Subscription Details</b></p>
                        <div>
                            <?php 
        	                	$subscription = $purchaseSubscription->subscription;
        						$transaction = $purchaseSubscription->transaction;
                        	?>
                        	<ul>
                                <li>Subscription Name : <span>{{$subscription->tile}}</span></li>
                    			<li>Subscription Price : <span>{{$transaction->amount / 100}}</span></li>
                    			<li>Valid Till : <span>{{date('M,d Y',strtotime($purchaseSubscription->valid_till))}}</span></li>
                    			<li>Transaction Id : <span>{{$transaction->transactionId}}</span></li>
                		        <li><a href="{{route('user.subscription')}}">View your Subscription</a></li>
                            </ul>
                        </div>
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
                    <h3>For <span>Purchase</span> Subscription</h3>
                </div>
                <p>
                	<?php 
	                	$subscription = $purchaseSubscription->subscription;
						$transaction = $purchaseSubscription->transaction;
                	?>
                	<ul>
                		<li><h1>Subscription Details</h1></li>
                		<ul>
                			<li>Subscription Name : {{$subscription->tile}}</li>
                			<li>Subscription Price : {{$transaction->amount / 100}}</li>
                			<li>Valid Till : {{date('M,d Y',strtotime($purchaseSubscription->valid_till))}}</li>
                		</ul>
                		<li>Transaction Id : {{$transaction->transactionId}}</li>
                		<li><a href="{{route('user.subscription')}}">View your Subscription</a></li>
                	</ul>
                </p>
            </div>-->
        </div>
    </div>
@endsection
