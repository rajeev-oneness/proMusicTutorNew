@extends('layouts.master')
@section('title','Product Series')
@section('content')
    <!-- <section class="banner guitar_banner">
        <div class="container">
            <div class="row m-0">
                <div class="col-12 col-md-5">
                    <h1>Welcome to <span class="d-block">Pro Music Tutor</span></h1>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </p>
                    <form>
                        <div class="form-group row m-0 mb-4">
                            <label class="col-md-3 col-6 col-form-label">Currencies:</label>
                            <div class="col-md-4 col-6">
                                <select class="form-control">
                                    <option>&pound; - GBP</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-group row m-0">
                            <input type="text" class="form-control keyword" placeholder="Enter Keyword...">
                            <div class="input-group-append">
                                <button class="btn viewmore" type="button">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section> -->

    @if(count($data->category) > 0)
        <section class="pt-5 pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center title-inner">
                        <h1 class="mb-5">Choose Your Category</h1>
                        <!-- <h1 class="mb-5">Choose Your Guitar Series Category</h1> -->
                    </div>
                </div>
                <div class="row m-0">
                    @php
                        $instrumentParameter = [];
                        if($data->instrument){
                            $instrumentParameter = [
                                'instrumentId' => $data->instrument->id,
                                'instrumentName' => $data->instrument->name,
                            ];
                        }
                    @endphp
                    @foreach($data->category as $index => $cat)
                        @php
                            $categoryParameter = $instrumentParameter;
                            $categoryParameter['categoryId'] = $cat->id;
                            $categoryParameter['categoryName'] = $cat->name;
                        @endphp
                        <div class="col-12 col-sm-6 col-md-4 mb-3">
                            <div class="card border-0 ">
                                <img src="{{asset($cat->image)}}" class="card-img-top">
                                <div class="card-body p-0">
                                  <a href="{{route('product.series',$categoryParameter)}}" class="btn signbtn">{{$cat->name}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="mt-5 mb-5 pt-5 pb-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-6 text-center title-inner">
                    <h1 class="mb-5">All Series @if($data->instrument){{' Related to '.$data->instrument->name}}@endif</h1>
                </div>
                <div class="col-6">
                    <form method="post" action="{{route('product.series',$instrumentParameter)}}">
                        @csrf
                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-4 col-form-label">Difficulty</label>
                                <select class="form-control form-control-sm" name="difficulty">
                                    <option value="" selected="" hidden="">Difficulty</option>
                                    <option {{($req->difficulty == 'Easy') ? 'selected' : ''}} value="Easy">Easy</option>
                                    <option {{($req->difficulty == 'Medium') ? 'selected' : ''}} value="Medium">Medium</option>
                                    <option {{($req->difficulty == 'Hard') ? 'selected' : ''}} value="Hard">Hard</option>
                                </select>
                            </div>
                            <a href="{{route('product.series',$instrumentParameter)}}">Reset</a>
                            <input type="submit" name="" class="btn">
                        </div>
                    </form>
                </div>
            </div>
            @if(count($data->guitarSeries) > 0)
                <div class="row m-0">
                    @foreach($data->guitarSeries as $key => $series)
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="card border-0 bg-transparent more-course">
                                <img src="{{asset($series->image)}}" class="card-img-top">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{$series->title}}</h5>
                                    <p class="card-text">{!! words($series->description,200) !!}</p>
                                    <?php $seriesPrice = calculateLessionPrice($series->lession); ?>
                                    @guest
                                        <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="alert('please login to continue')">BUY FULL SERIES - &pound;  {{$seriesPrice}}</a>
                                    @else
                                        @if($series->userPurchased)
                                            <a href="javascript:void(0)" class="btn purchased-Full mb-3">Already Purchased</a>
                                        @else
                                            <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="stripePaymentStart('{{$seriesPrice}}','{{route('after.purchase.guitar_series',$series->id)}}');">BUY FULL SERIES - &pound;  {{$seriesPrice}}</a>
                                        @endif
                                    @endguest
                                </div>
                                <div class="card-footer d-flex border-0 p-0">
                                    <a href="{{route('product.series.details',$series->id)}}" class="btn detail col-6">Details</a>
                                    <a href="javascript:void(0)" class="btn preview col-6">PREVIEW</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- <div class="text-center mt-5">
                    <a href="javascript:void(0)" class="btn viewmore">EXPLORE MORE</a>
                </div> -->
            @else
                <div>No Series found</div>
            @endif
        </div>
    </section>
@endsection
@section('script')
<script type="text/javascript"></script>
@endsection