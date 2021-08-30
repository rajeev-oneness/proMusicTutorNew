@extends('layouts.master')
@section('title','How it Works')
@section('content')
    
    <div class="inner-banner">
        <img class="full-image" src="{{asset($howitworkMain->image)}}">
    </div>

    <section class="how-it-works">
        <div class="container">
            <div class="text-center mb-95">
                <h1 class="how-it-heading">{{$howitworkMain->heading}}</h1>
                <p>{!! $howitworkMain->description !!}</p>
            </div>
            <div class="row justify-content-center">
                @foreach(\App\Models\Setting::getSetting('howitworkChild') as $key => $howItWorkChild)
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mb-5">
                        <div class="how-area">
                            <div class="how-icon text-center">
                                <img src="{{asset($howItWorkChild->image)}}">
                            </div>
                            <div class="how-text text-center">
                                <h3>{{$howItWorkChild->heading}}</h3>
                                <p>{!! $howItWorkChild->description !!}</p>
                                <div class="text-right">
                                    <a href="javascript:void(0)"><img src="{{asset('design/img/right-arrow.png')}}"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
