@extends('layouts.master')
@section('title','Tutor List')
@section('content')
<section class="pt-3 pt-md-5 pb-3 pb-md-5 tutor-list bg-light">
    <div class="container">
        <div class="row m-0 my_teams">
            <div class="col-12 text-center">
                <h1 class="mb-5">Tutor's List</h1>
            </div>
        </div>

        <div class="row justify-content-between m-0 mb-5 align-content-center align-items-center">
            <div class="col-12 col-lg-4">
                <ul class="bredcamb">
                    <li><a href="{{route('welcome')}}">Home</a></li>
                    <li>/</li>
                    <li><a href="javascript:void(0)" class="active">Tutor's</a></li>
                </ul>
            </div>
            <!-- <form class="col-12 col-lg-4">
	            <div class="form-group row m-0 sortby">
	                <label class="col-sm-4 col-form-label">Sort By</label>
	                <div class="col-sm-8">
		                <select class="form-control form-control-sm">
		                    <option value="featured">Featured</option>
		                    <option value="newest">Newest</option>
		                    <option value="alphaasc" selected="">A - Z</option>
		                    <option value="alphadesc">Z - A</option>
		                    <option value="avgcustomerreview">Reviews</option>
		                </select>
	                </div>
	            </div>
            </form> -->
        </div>

        <div class="row justify-content-start m-0">
        	@foreach($tutor as $key => $tutor_data)
	            <div class="col-12 col-lg-3 mb-3">
	                <div class="card border-0">
	                    <div class="item">
                            <div class="card text-center tutior_list_d">
                                <img src="{{asset($tutor_data->image)}}" class="card-img-top" style="height: 180px;">
                                <div class="card-body pb-1">
                                    <div class="img_border"></div>
                                    <h5 class="card-title">{{$tutor_data->name}}</h5>
                                    <p class="card-text">{!! words($tutor_data->about,200) !!}</p>
                                    <a href="{{route('explore.tutor',[base64_encode($tutor_data->id),'tutor'=>$tutor_data->name])}}" class="float-right"><i class="fas fa-long-arrow-alt-right"></i></a>
                                </div>
                            </div>
                        </div>
	                </div>
	            </div>
            @endforeach
            <div class="col-12" style="margin-left: 100%;">{{ $tutor->withQueryString()->links() }}</div>
            <!-- <div class="col-12 text-center mt-5">
                <a href="javascript:void(0)" class="btn viewmore">View More</a>
            </div> -->
        </div>
    </div>
</section>
@section('script')
    <script type="text/javascript"></script>
@stop
@endsection