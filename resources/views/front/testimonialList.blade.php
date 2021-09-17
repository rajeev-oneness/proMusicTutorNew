@extends('layouts.master')
@section('title','Testimonial List')
@section('content')
<section class="pt-3 pt-md-5 pb-3 pb-md-5 testimonial bg-light">
        <div class="container">
            <div class="row m-0 my_teams">
                <div class="col-12 text-center">
                    <h1 class="mb-5">Members Are Saying</h1>
                </div>
            </div>
            <div class="row justify-content-between m-0 mb-5 align-content-center align-items-center">
                <div class="col-12 col-lg-4">
                    <ul class="bredcamb">
                        <li><a href="{{route('welcome')}}">Home</a></li>
                        <li>/</li>
                        <li><a href="javascript:void(0)" class="active">Testimonial</a></li>
                    </ul>
                </div>
                <form id="sortingTestimonialForm" class="col-12 col-lg-4" action="{{route('explore.testimonials')}}">
                    <div class="form-group row m-0 sortby">
                        <label class="col-sm-4 col-form-label">Sprt By</label>
                        <div class="col-sm-8">
                            <select name="sorting" class="form-control form-control-sm" onchange="submit('#sortingTestimonialForm')">
                                <option value="desc" @if(!empty($req->sorting) && $req->sorting=='desc'){{('selected')}}@endif>Newest First</option>
                                <option value="asc" @if(!empty($req->sorting) && $req->sorting=='asc'){{('selected')}}@endif>Oldset First</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row m-0 justify-content-start">
                @foreach($data->testimonials as $key => $member)
                    <div class="col-12 col-lg-6 mb-4 mb-lg-5">
                        <div class="testitext">
                            <img src="{{asset('design/img/quote.png')}}" class="quote_icon">
                            <p>{!! words($member->quote,200) !!}</p>
                            <div class="d-flex align-items-center align-content-center mt-4">
                                <div class="user_pic"><img src="{{asset($member->image)}}"></div>
                                <h6>{{$member->name}}<span>{{$member->address}}</span></h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@section('script')
    <script type="text/javascript"></script>
@stop
@endsection