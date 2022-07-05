@extends('layouts.master')
@section('title','How it Works')
@section('content')
    
    <div class="inner-banner mt-85">
        <img class="full-image" src="{{asset($howitworkMain->image)}}">
    </div>

    <section class="how-it-works bg-light">
        <div class="container">
            <div class="row my_teams pt-4 pt-md-5 mb-4 mb-md-5">
                <div class="text-left col-12">
                    <h1 class="">{{$howitworkMain->heading}}</h1>
                    <p>{!! $howitworkMain->description !!}</p>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach(\App\Models\Setting::getSetting('howitworkChild') as $key => $howItWorkChild)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
                        <div class="how-area">
                            <div class="how-icon text-left mb-4">
                                <img src="{{asset($howItWorkChild->image)}}">
                            </div>
                            <div class="how-text text-left">
                                <h3 class="mb-3">{{$howItWorkChild->heading}}</h3>
                                <p>{!! $howItWorkChild->description !!}</p>
                                <div class="text-right">
                                    <a href="javascript:void(0)">More <img src="{{asset('design/img/right-arrow.png')}}" style="width: 17px; margin-left: 5px;"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
