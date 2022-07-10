@extends('layouts.master')
@section('title','Product Series')

@section('content')
	<section class="pt-3 pt-md-5 pb-3 pb-md-5 tutor-list bg-light">
    <div class="container">
        <div class="row m-0 my_teams">
            <div class="col-12 text-center">
                <h1 class="mb-5">Guitar Series</h1>
                <div class="col-12 pt-3">
                    <p>Our guitar lessons are bought to you by a combination of famous faces and some of the most in-demand session musicians in the world. Our featured guitar tutors include Whitesnake’s Micky Moody, as well as Jerry Crozier Cole, and Denny Ilett, who has toured New Orleans to great acclaim and is hugely popular.</p>
                    <p>Whether it's learning the best pro licks to improve your improvisation skills or discovering how to play an all-time rock classic from start to finish, we have guitar lessons for everyone here at Pro Music Tutor.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-between m-0 mb-5 align-items-center">
            <div class="col-12 col-md-12 mb-4 mb-lg-5">
                <ul class="bredcamb">
                    <li><a href="{{route('welcome')}}">Home</a></li>
                    <li>/</li>
                    <li><a href="javascript:void(0)" class="active">Guitar</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-12 filter_section">
				<form method="post" action="{{route('browse.guiter.series')}}" class="w-100">
					@csrf
					<div class="w-100 d-flex justify-content-end filter-flex">
						<div class="form-group mb-0 mr-2">
							<!--<label>Currency</label>-->
							<select class="form-control form-control-sm" name="currency">
								<option value="" selected="" disabled>Currency</option>
								<option value="usd">$ USD</option>
								<option {{($req->currency == 'eur') ? 'selected' : ''}} value="eur">€ EUR</option>
								<option {{($req->currency == 'gbp') ? 'selected' : ''}} value="gbp">£ GBP</option>
							</select>
						</div>
						
						<div class="form-group mb-0 mr-3">
							<!--<label>Category</label>-->
							<select class="form-control form-control-sm" name="category">
								<option value="" selected="" disabled>Category</option>
								@foreach($data->category as $cat)
									<option value="{{$cat->id}}" {{($req->category == $cat->id) ? 'selected' : ''}}>{{$cat->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group mb-0 mr-3">
							<!--<label>Difficulty</label>-->
							<select class="form-control form-control-sm" name="difficulty">
								<option value="" selected="" disabled>Difficulty</option>
								<option {{($req->difficulty == 'Easy') ? 'selected' : ''}} value="Easy">Easy</option>
								<option {{($req->difficulty == 'Medium') ? 'selected' : ''}} value="Medium">Medium</option>
								<option {{($req->difficulty == 'Hard') ? 'selected' : ''}} value="Hard">Hard</option>
							</select>
						</div>
						<div class="form-group mb-0 mr-2">
							<!--<label>Tutor</label>-->
							<select class="form-control form-control-sm" name="tutor">
								<option value="" selected="" disabled>Tutor</option>
								@foreach($data->tutor as $teacher)
									<option value="{{$teacher->id}}" {{($req->tutor == $teacher->id) ? 'selected' : ''}}>{{$teacher->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group mb-0 mr-2">
							<input type="text" name="search" class="form-control" value="{{($req->search ?? '')}}" placeholder="Search ...">
						</div>
						<!-- if Search Module Happend -->
						
						
						<div class="form-group mb-0 mr-2">
							<button type="submit" class="btn buyfull">Apply</button>
							<a href="{{route('browse.product.series')}}" class="btn detail">Reset</a>
						</div>
					</div>
				</form>
			</div>
        </div>
        @if(count($data->guitarSeries) > 0)
	        <section class="mt-5 mb-5 pt-0 pb-5 bg-light">
	            <div class="container">
	                <div class="row m-0">
	                    @foreach($data->guitarSeries as $key => $series)
	                        <div class="col-12 col-sm-6 col-lg-4">
	                            <div class="card border-0 bg-transparent more-course">
	                                <img src="{{asset($series->image)}}" class="card-img-top">
	                                <div class="card-body text-center">
	                                    <h5 class="card-title">{{$series->title}}</h5>
	                                    <p class="card-text">{!! words($series->description,200) !!}</p>
	                                    <?php $seriesPrice = calculateLessionPrice($series, $data->currency); ?>
	                                    @guest
	                                        <a href="javascript:void(0)" class="btn buyfull" onclick="alert('please login to continue')">BUY FULL SERIES - {{currencySymbol($data->currency)}} {{$seriesPrice}}</a>
	                                    @else
	                                        @if($series->userPurchased)
	                                            <a href="javascript:void(0)" class="btn purchased-Full">Already Purchased</a>
	                                        @else
	                                            <a href="javascript:void(0)" class="btn buyfull" onclick="stripePaymentStart('{{$seriesPrice}}','{{route('after.purchase.guitar_series',$series->id)}}', '{{$data->currency}}');">BUY FULL SERIES - {{currencySymbol($data->currency)}} {{$seriesPrice}}</a>
	                                            <!-- Add To Cart -->
	                                            <a class="btn btn-lg" onclick="addOrRemoveUserProductCart('{{$user->id}}','series','{{$series->id}}','add','{{$data->currency}}')"><i class="fas fa-cart-plus"></i></a>
	                                        @endif
	                                    @endguest
	                                </div>
	                                <div class="card-footer d-flex border-0 p-0">
	                                    <a href="{{route('product.series.details',$series->id)}}" class="btn detail col-12 col-md-6">Details</a>
	                                    <a href="javascript:void(0)" class="btn preview col-12 col-md-6" onclick="previewVideo({{$series->id}}, '{{$series->video_url}}', '{{$series->title}}')">PREVIEW <i class="fa fa-play ml-2"></i></a>
	                                </div>
									<div class="difficulty_section right-0">
										{{$series->difficulty}}
									</div>
	                            </div>
	                        </div>
	                    @endforeach
	                </div>
	                <div class="col-12 pg_pro">{{ $data->guitarSeries->withQueryString()->links() }}</div>
	                <!-- <div class="text-center mt-5">
	                    <a href="javascript:void(0)" class="btn viewmore">EXPLORE MORE</a>
	                </div> -->
	            </div>
	        </section>
	    @else
		    <div>No Series found</div>
	    @endif
    </div>
</section>
@section('script')
    <script type="text/javascript"></script>
@stop
@endsection