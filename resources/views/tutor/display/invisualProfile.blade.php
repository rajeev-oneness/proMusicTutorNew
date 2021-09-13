@extends('layouts.master')
@section('title',($tutor ? $tutor->name : 'Profile'))
@section('content')

<section class="teacher_profile mb-5">
    <div class="tutoe_detail">
        <div class="container">
            <div class="row m-0 align-content-center align-items-center">
                <div class="col-12 col-lg-3 mb-4 mb-lg-0">
                    <img src="{{asset($tutor->image)}}" class="w-100">
                </div>
                <div class="col-12 col-lg-6 tutor_detail">
                    <h3>{{$tutor->name}} <span>{{$tutor->specialist}}</span></h3>
                    <span>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <small>{{number_format($tutor->ratings->avg('rating'),1)}} <i class="fas fa-star"></i></small>
                    </span>
                    <p><span>Experience:</span>@if($tutor->carrier_started == '0000-00-00'){{(' 0')}}@else{{date('Y') - date('Y',strtotime($tutor->carrier_started))}}@endif{{(' years')}}</p>
                </div>
                <div class="col-12 col-lg-3 social_icon">
                	@if($link = $tutor->user_profile)
	                    <h4 class="mb-3">FOLLOW US</h4>
	                    @if($link->fb_link != '')
		                    <a href="{{$link->fb_link}}" target="_blank"><i class="fab fa-facebook-f"></i></a>
	                    @endif
	                    @if($link->twitter_link != '')
		                    <a href="{{$link->twitter_link}}" target="_blank"><i class="fab fa-twitter"></i></a>
	                    @endif
	                    @if($link->instagram_link != '')
		                    <a href="{{$link->instagram_link}}" target="_blank"><i class="fab fa-instagram"></i></a>
	                    @endif
	                    @if($link->youtube_link != '')
		                    <a href="{{$link->youtube_link}}" target="_blank"><i class="fab fa-youtube"></i></a>
	                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row m-0 mt-4 mt-lg-5 justify-content-lg-between">
            <div class="col-12 col-lg-12">
                <div class="Card border-0 mb-4 shadow-sm p-3">
                    <h4 class="mb-3">About Me</h4>
                    {!! $tutor->about !!}
                </div>
            </div>

            @if(count($tutor->product_series) > 0)
            <div class="col-12 p-0">
            	<div class="row">
		            <div class="col-12 text-center title-inner">
		                <h1 class="mb-5">His Series's</h1>
		            </div>
		        </div>
                <div class="row m-0 mb-4">
                	@foreach($tutor->product_series as $index => $productSeries)
	                    <div class="col-12 col-sm-6 col-md-4 mb-3">
	                        <div class="card border bg-transparent more-course">
		                        <img src="{{asset($productSeries->image)}}" class="card-img-top">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{$productSeries->title}}</h5>
                                    <p class="card-text">{!! words($productSeries->description,200) !!}</p>
	                                <?php $seriesPrice = calculateLessionPrice($productSeries->lession); ?>
                                    @guest
                                        <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="alert('please login to continue')">BUY FULL SERIES - &pound;  {{$seriesPrice}}</a>
                                    @else
                                        @if($productSeries->userPurchased)
                                            <a href="javascript:void(0)" class="btn purchased-Full mb-3">Already Purchased</a>
                                        @else
                                            <!-- Checkout Form -->
                                            <form id="checkoutForm{{$productSeries->id}}" action="{{route('razorpay.payment.store')}}" method="POST" >
                                                @csrf
                                                <input type="hidden" name="redirectURL" value="{{route('after.purchase.guitar_series',$productSeries->id)}}">
                                                <script src="https://checkout.razorpay.com/v1/checkout.js"
                                                        data-key="{{ env('RAZORPAY_KEY') }}"
                                                        data-amount="{{($seriesPrice) * 100}}"
                                                        /****data-buttontext="Pay {{$seriesPrice}} INR"****/
                                                        data-name="Pro Music Tutor"
                                                        data-description="All downloads available in FULL HD or stream"
                                                        data-image="{{asset('defaultImages/logo.jpeg')}}"
                                                        /*data-prefill.name=""
                                                        data-prefill.email=""*/
                                                        data-theme.color="#ff7529">
                                                </script>
                                                <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="$('#checkoutForm{{$productSeries->id}}').submit()">BUY FULL SERIES - &pound;  {{$seriesPrice}}</a>
                                            </form>
                                        @endif
                                    @endguest
	                            </div>
	                            <div class="card-footer d-flex border-0 p-0">
	                                <a href="{{route('product.series.details',$productSeries->id)}}" class="btn detail col-6">Details</a>
	                                <a href="javascript:void(0)" class="btn preview col-6">PREVIEW</a>
	                            </div>
	                        </div>
	                    </div>
	                @endforeach
                </div>
            </div>
            @endif

            <div class="col-12 col-lg-7">
                <div class="card border-0 shadow-sm comment_section p-3">
                    <h4 class="mb-3"><span id="ratingCount">{{count($tutor->ratings)}}</span> Reviews</h4>
                    <div class="scroll-rev ratingToBeAppend">
                    	@foreach($tutor->ratings as $key => $rating)
	                        <div class="mt-2 row m-0 rev-list">
	                            <div class="col-12 col-lg-1 p-0">
	                                <div class="review_isur">
	                                    <img src="{{asset($rating->rated_user_details->image)}}">
	                                </div>
	                            </div>
	                            <div class="col-12 col-lg-10">
	                                <h6>
	                                    {{$rating->rated_user_details->name}}
	                                    <span>{{date('M d, Y H:i A',strtotime($rating->created_at))}}</span>
	                                </h6>
	                                <p>{{$rating->comment}}</p>
	                            </div>
	                        </div>
	                    @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5 mt-4 mt-lg-0" id="postReviewSection">
                <h6 class="mb-3">ADD REVIEW</h6>
                <!-- <form class="bg-light p-3"> -->
                    <div class="row m-0 mb-3">
                        <div class="rate p-0">
                            <input type="radio" id="star5" name="rating" value="5"/>
                            <label for="star5" title="5 stars">5 stars</label>
                            <input type="radio" id="star4" name="rating" value="4"/>
                            <label for="star4" title="4 stars">4 stars</label>
                            <input type="radio" id="star3" name="rating" value="3"/>
                            <label for="star3" title="3 stars">3 stars</label>
                            <input type="radio" id="star2" name="rating" value="2"/>
                            <label for="star2" title="2 stars">2 stars</label>
                            <input type="radio" id="star1" name="rating" value="1"/>
                            <label for="star1" title="1 star">1 star</label>
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-12 col-lg-12 pl-0 pr-1">
                            <div class="form-group">
                                <textarea class="form-control" name="ratingMessage" rows="3" placeholder="Message...."></textarea>
                              </div>
                        </div>
                        <small class="text-danger" id="reviewError"></small>
                        <div class="col-12 col-lg-12 d-flex justify-content-end">
                            <button class="btn viewmore mt-0 mb-3 postComment">Post comment</button>
                        </div>
                    </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
</section>

@section('script')
    <script type="text/javascript">
    	var ratingCount = {{count($tutor->ratings)}};
    	$(document).on('click','.postComment',function(){
    		@guest
				<?php Session::put('url.intended', URL::full()); ?>
				window.location.href = '{{route('login')}}';
			@else
				$('#reviewError').text('');
	    		var comment = $('#postReviewSection textarea[name=ratingMessage]').val();
				if(comment == ''){
					$('#reviewError').text('Please type your comment');
				}
				var rating = $('#postReviewSection input[name=rating]:checked').val();
				if(rating == null || rating == undefined || rating == ''){
					$('#reviewError').text('Please rate');
				}
				if(comment != '' && (rating != '' || rating != 0)){
					postTutorRating(rating,comment);	
				}
			@endguest
    	});
    	
    	// Submit Comment Rating
		@auth
	    	function postTutorRating(rating,comment)
	    	{
				$.ajax({
					url : "{{route('tutor.rating.post')}}",
					type : 'POST',
					dataType : 'JSON',
					data : {
						tutorId:'{{$tutor->id}}',
						ratedUserId:'{{$user->id}}',
						comment:comment,
						rating:rating,
						_token : '{{csrf_token()}}'
					},
					success:function(response){
						if(response.error == false){
							$('#postReviewSection textarea[name=ratingMessage]').val('');
							// $('#postReviewSection input[name=rating]').val('');
							var toAppend = '<div class="mt-2 row m-0 rev-list"><div class="col-12 col-lg-1 p-0"><div class="review_isur"><img src="{{asset('')}}'+response.data.rated_user_details.image+'"></div></div><div class="col-12 col-lg-10"><h6>'+response.data.rated_user_details.name+'<span>'+response.data.posted_date+'</span></h6><p>'+response.data.comment+'</p></div></div>';
							$('.ratingToBeAppend').prepend(toAppend);
							ratingCount += 1;
							$('#ratingCount').text(ratingCount);
						}else{
							$('#reviewError').text(response.message);
						}
					},error:function(response){
						$('#reviewError').text('Somethig went wrong');
					}
				});
	    	}
    	@endauth
    	$('.razorpay-payment-button').remove();
    </script>
@stop
@endsection