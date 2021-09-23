@extends('layouts.master')
@section('title','About Us')
@section('content')
    <section class="pt-6 pb-5">
        <h1 class="text-center my-4">{{$data->aboutus->heading}}</h1>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-5">
                    <img src="{{asset($data->aboutus->image)}}" class="w-100">
                </div>
                <div class="col-12 col-md-7 about-text">
                    {!! $data->aboutus->description !!}
                </div>
            </div>
        </div>
    </section>

    <section class="pt-3 pb-3 mt-2 mb-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 pt-3">
                    {!! $data->aboutus->description2 !!}
                </div>
            </div>
        </div>
    </section>
@endsection