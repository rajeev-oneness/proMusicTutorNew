@extends('layouts.master')
@section('title','Product Series')

@section('content')
	<section class="pt-3 pt-md-5 pb-3 pb-md-5 tutor-list bg-light">
    <div class="container">
        <div class="row m-0 my_teams">
            <div class="col-12 text-center">
                <h1 class="mb-5">All Series</h1>
            </div>
        </div>

        <div class="row justify-content-between m-0 mb-5 align-content-center align-items-center">
            <div class="col-12 col-md-3">
                <ul class="bredcamb mt-4">
                    <li><a href="{{route('welcome')}}">Home</a></li>
                    <li>/</li>
                    <li><a href="javascript:void(0)" class="active">Series's</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-9">
				<form method="post" action="{{route('browse.product.series')}}" class="w-100">
					@csrf
					<div class="w-100 d-flex justify-content-end">
						<div class="form-group mb-0 mr-2">
							<label>Currency</label>
							<select class="form-control form-control-sm" name="currency">
								<option value="" selected="" hidden="">Price</option>
								<option selected value="usd">$ USD</option>
								<option {{($req->currency == 'eur') ? 'selected' : ''}} value="eur">€ EUR</option>
								<option {{($req->currency == 'gbp') ? 'selected' : ''}} value="gbp">£ GBP</option>
							</select>
						</div>
						<div class="form-group mb-0 mr-2">
							<label>Instrument</label>
							<select class="form-control form-control-sm" name="instrument">
								<option value="" selected="" hidden="">Instrument</option>
								@foreach($data->instrument as $ins)
									<option value="{{$ins->id}}" {{($req->instrument == $ins->id) ? 'selected' : ''}}>{{$ins->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group mb-0 mr-2">
							<label>Category</label>
							<select class="form-control form-control-sm" name="category">
								<option value="" selected="" hidden="">Category</option>
								@foreach($data->category as $cat)
									<option value="{{$cat->id}}" {{($req->category == $cat->id) ? 'selected' : ''}}>{{$cat->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group mb-0 mr-2">
							<label>Difficulty</label>
							<select class="form-control form-control-sm" name="difficulty">
								<option value="" selected="" hidden="">Difficulty</option>
								<option {{($req->difficulty == 'Easy') ? 'selected' : ''}} value="Easy">Easy</option>
								<option {{($req->difficulty == 'Medium') ? 'selected' : ''}} value="Medium">Medium</option>
								<option {{($req->difficulty == 'Hard') ? 'selected' : ''}} value="Hard">Hard</option>
							</select>
						</div>
						<div class="form-group mb-0 mr-2">
							<label>Tutor</label>
							<select class="form-control form-control-sm" name="tutor">
								<option value="" selected="" hidden="">Tutor</option>
								@foreach($data->tutor as $teacher)
									<option value="{{$teacher->id}}" {{($req->tutor == $teacher->id) ? 'selected' : ''}}>{{$teacher->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group mb-0 mr-2" style="padding-top: 34px">
							<button type="submit" class="btn btn-sm btn-primary">Apply</button>
							<a href="{{route('browse.product.series')}}" class="btn btn-sm btn-light border">Reset</a>
						</div>
					</div>
				</form>
			</div>
        </div>
        @if(count($data->guitarSeries) > 0)
	        <section class="mt-5 mb-5 pt-5 pb-5 bg-light">
	            <div class="container">
	                <div class="row m-0">
	                    @foreach($data->guitarSeries as $key => $series)
	                        <div class="col-12 col-sm-6 col-md-4">
	                            <div class="card border-0 bg-transparent more-course">
	                                <img src="{{asset($series->image)}}" class="card-img-top">
	                                <div class="card-body text-center">
	                                    <h5 class="card-title">{{$series->title}}</h5>
	                                    <p class="card-text">{!! words($series->description,200) !!}</p>
	                                    <?php $seriesPrice = calculateLessionPrice($series->lession, $data->currency); ?>
	                                    @guest
	                                        <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="alert('please login to continue')">BUY FULL SERIES - {{currencySymbol($data->currency)}} {{$seriesPrice}}</a>
	                                    @else
	                                        @if($series->userPurchased)
	                                            <a href="javascript:void(0)" class="btn purchased-Full mb-3">Already Purchased</a>
	                                        @else
	                                            <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="stripePaymentStart('{{$seriesPrice}}','{{route('after.purchase.guitar_series',$series->id)}}', '{{$data->currency}}');">BUY FULL SERIES - {{currencySymbol($data->currency)}} {{$seriesPrice}}</a>
	                                        @endif
	                                    @endguest
	                                </div>
	                                <div class="card-footer d-flex border-0 p-0">
	                                    <a href="{{route('product.series.details',$series->id)}}" class="btn detail col-6">Details</a>
	                                    <a href="javascript:void(0)" class="btn preview col-6" onclick="previewVideo({{$series->id}}, '{{$series->video_url}}', '{{$series->title}}')">PREVIEW <i class="fa fa-play ml-2"></i></a>
	                                </div>
									<div class="difficulty_section right-0">
										{{$series->difficulty}}
									</div>
	                            </div>
	                        </div>
	                    @endforeach
	                </div>
	                <div class="col-12" style="margin-left: 100%;">{{ $data->guitarSeries->withQueryString()->links() }}</div>
	                <!-- <div class="text-center mt-5">
	                    <a href="javascript:void(0)" class="btn viewmore">EXPLORE MORE</a>
	                </div> -->
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