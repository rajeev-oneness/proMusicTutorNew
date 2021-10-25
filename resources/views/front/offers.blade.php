@extends('layouts.master')
@section('title','Offers')
@section('content')
	<section class="pt-3 pt-md-5 pb-3 pb-md-5 tutor-list bg-light">
    <div class="container">
        <div class="row m-0 my_teams">
            <div class="col-12 text-center">
                <h1 class="mb-5">Offers</h1>
            </div>
        </div>

        <div class="row justify-content-between m-0 mb-5 align-items-center">
            <div class="col-12 col-md-6">
                <ul class="bredcamb mt-4">
                    <li><a href="{{route('welcome')}}">Home</a></li>
                    <li>/</li>
                    <li><a href="javascript:void(0)" class="active">Offers</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-6">
				<form method="post" action="{{route('front.offers')}}" class="w-100">
					@csrf
					<div class="w-100 d-flex justify-content-end filter_section">
						<div class="form-group mb-0 mr-2">
							<!--<label>Currency</label>-->
							<select class="form-control form-control-sm" name="currency">
								<option value="" selected="" disabled>Currency</option>
								<option selected value="usd">$ USD</option>
								<option {{($req->currency == 'eur') ? 'selected' : ''}} value="eur">€ EUR</option>
								<option {{($req->currency == 'gbp') ? 'selected' : ''}} value="gbp">£ GBP</option>
							</select>
						</div>
						<div class="form-group mb-0 mr-2">
							<button type="submit" class="btn buyfull">Apply</button>
							<a href="{{route('front.offers')}}" class="btn detail">Reset</a>
						</div>
					</div>
				</form>
			</div>
        </div>
        @if(count($data->offers) > 0)
	        <section class="mt-5 mb-5 pt-5 pb-5 bg-light">
	            <div class="container">
	                <div class="row m-0">
	                    @foreach($data->offers as $key => $offer)
	                        <div class="col-12 col-sm-6 col-md-4">
	                            <div class="card border-0 bg-transparent more-course">
	                                <img src="{{asset($offer->image)}}" class="card-img-top">
	                                <div class="card-body text-center">
	                                    <h5 class="card-title">{{$offer->title}}</h5>
	                                    <p class="card-text">{!! words($offer->description,100) !!}</p>

                                        @php
											$offerPrice = $offer->price_usd;

											if(!empty($req->currency)) {
												if($req->currency == 'eur') {
													$offerPrice = $offer->price_euro;
												} elseif ($req->currency == 'gbp') {
													$offerPrice = $offer->price_gbp;
												} else {
													$offerPrice = $offer->price_usd;
												}
											}
                                        @endphp

                                        @guest
	                                        <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="alert('please login to continue')">BUY NOW - {{currencySymbol($data->currency)}} {{$offerPrice}}</a>
	                                    @else
	                                        @if($offer->userPurchased)
	                                            <a href="javascript:void(0)" class="btn purchased-Full mb-3">Already Purchased</a>
	                                        @else
	                                            <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="stripePaymentStart('{{$offerPrice}}','{{route('after.purchase.offer_series', $offer->id)}}', '{{$data->currency}}');">BUY NOW - {{currencySymbol($data->currency)}} {{$offerPrice}}</a>
	                                            <!-- Add To Cart -->
	                                            <a class="btn btn-lg" onclick="addOrRemoveUserProductCart('{{$user->id}}','offer','{{$offer->id}}','add','{{$data->currency}}')"><i class="fas fa-cart-plus"></i></a>
	                                        @endif
	                                    @endguest
	                                </div>
	                                <div class="card-footer d-flex border-0 p-0">
	                                    <a href="{{route('front.offers.detail', $offer->id)}}" class="btn detail col-6">Details</a>
	                                    <a href="javascript:void(0)" class="btn preview col-6">PREVIEW</a>
	                                </div>
	                            </div>
	                        </div>
	                    @endforeach
	                </div>
	            </div>
	        </section>
	    @else
		    <div>No data found</div>
	    @endif
    </div>
</section>
@section('script')
    <script type="text/javascript"></script>
@stop
@endsection