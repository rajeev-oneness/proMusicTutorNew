@extends('layouts.master')
@section('title','Offer details')

@section('content')
@php
    $totalPrice = $data->price_usd;
    $symbol = currencySymbol('usd');
@endphp
    <section class="pt-0 pt-md-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 shadow-lg p-0 mb-4 mb-md-0">
                    <img src="{{asset($data->image)}}" alt="" class="w-100">
                </div>
                <div class="col-md-6 col-12">
                    <div class="row m-0">
                        <h5 class="col-12 pt-2 pl-0 pl-md-3">{{$data->title}}</h5>
                        <div class="col-12 mt-4">
                        @php
                            $offerPrice = $data->price_usd;
                            $symbol = currencySymbol('usd');
                        @endphp

                        @guest
                            <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="alert('please login to continue')">BUY NOW - {{$offerPrice}}</a>
                        @else
                        @if($data->userPurchased)
                            <a href="javascript:void(0)" class="btn purchased-Full mb-3">Already Purchased</a>
                        @else
                            <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="stripePaymentStart('{{$offerPrice}}','{{route('after.purchase.offer_series', $data->id)}}');">BUY NOW - {{$symbol.' '.$offerPrice}}</a>
                        @endif
                        @endguest
                        </div>
                    </div>
                    <div class="col-12 pt-3 pl-0 pl-md-3">
                        <h6 class="mb-3">Description</h6>
                        <p>{!! $data->description !!}</p>
                    </div>
                    <div class="col-12 pt-3 pl-0 pl-md-3">
                        <h6 class="mb-3">Offer Description</h6>
                        <p>{!! $data->offer_description !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @if(count($data->offerSeries) > 0)
        <section class="pt-2 mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center title-inner">
                        <h1 class="mb-5">Series in this offer</h1>
                    </div>
                </div>
                <div class="row m-0">
                    @foreach($data->offerSeries as $index => $series)
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="card border-0 bg-transparent more-course">
                                <img src="{{asset($series->series_details->image)}}" class="card-img-top" alt="...">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{$series->series_details->title}}</h5>
                                    <p class="card-text">{!! words($series->series_details->description,200) !!}</p>
                                    <?php $seriesPrice = calculateLessionPrice($series->series_details->lession); ?>
                                    @guest
                                        <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="alert('please login to continue')">BUY FULL SERIES - $ {{$seriesPrice}}</a>
                                    @else
                                        @if($series->userPurchased)
                                            <a href="javascript:void(0)" class="btn purchased-Full mb-3">Already Purchased</a>
                                        @else
                                            <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="stripePaymentStart('{{$seriesPrice}}','{{route('after.purchase.guitar_series',$series->series_details->id)}}');">BUY FULL SERIES - $ {{$seriesPrice}}</a>
                                        @endif
                                    @endif
                                </div>
                                <div class="card-footer d-flex border-0 p-0">
                                    <a href="{{route('product.series.details',$series->series_details->id)}}" class="btn detail col-6">Details</a>
                                    <a href="javascript:void(0)" class="btn preview col-6">PREVIEW</a>
                                </div>
                                <div class="difficulty_section right-0">
                                    {{$series->series_details->difficulty}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    {{-- here --}}


@endsection
@section('script')
<script type="text/javascript"></script>
@endsection