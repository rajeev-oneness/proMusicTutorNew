@extends('layouts.master')
@section('title','Welcome')
@section('content')
    <section class="banner">
        <div class="container">
            <div class="row m-0">
                <div class="col-12 col-md-5">
                    <h1>Welcome to <span class="d-block">Pro Music Tutor</span></h1>
                    <p>
                        Pro Music Tutor offers a range of high definition music tutoring videos and exceptional quality backing tracks. Our instructional videos feature tutors selected for their reputation and talent with the guitar and with the saxophone.
                    </p>
                    <a href="javascript:void(0)" class="btn viewmore">View More</a>
                    @if(Route::has('register'))
                        <a href="{{route('register')}}" class="btn signbtn">SIGN UP FOR FREE</a>
                    @endif
                </div>
            </div>
        </div>
    </section><!--banner-->

    @if(count($data->instrument) > 0)
        <section class="pt-6">
            <div class="container">
                <div class="row align-content-center justify-content-center">
                    @foreach($data->instrument as $index => $instrument)
                        <div class="col-12 col-md-4 position-relative mb-3">
                            <img src="{{asset($instrument->image)}}" class="w-100">
                            <div class="img-title">
                                <h5>{{$instrument->name}}</h5>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12 col-md-4 position-relative newarival order-first order-md-12 mb-3">
                        <h1 class="text_orange">
                            <span class="d-block">GET </span>STARTED <span class="d-block">NOW </span>
                        </h1>
                        <h6 class="text-muted mb-4 mt-3 w-50">BY CHOOSING YOUR INSTRUMENT.</h6>
                        <a href="javascript:void(0)" class="btn viewmore">Explore More</a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="mt-5 pt-3 pt-md-0 pb-0 bg-light overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 body-title pt-6 appdownload">
                    <h1 class="text_orange pt-0 pt-md-5">Let’s Enjoy With <span class="d-block">Pro Music Tutor</span></h1>
                    <p>
                        Pro Music Tutor offers a range of high definition music tutoring videos and exceptional quality backing tracks. Our instructional videos feature tutors selected for their reputation and talent with the guitar and with the saxophone.
                    </p>
                    <a href="#" class="btn signbtn">Download and watch offline</a>
                    <a href="#" class="btn viewmore">GET STARTED</a>
                </div>
                <div class="col-12 col-md-6 resp_img">
                    <img src="{{asset('design/img/pic-1.png')}}">
                </div>
            </div>
        </div>
    </section>

    @if(count($data->tutor) > 0)
        <section class="pt-5 pb-5 my_teams">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="mb-5">Meet The Tutor's</h1>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-10 columns">
                        <div class="owl-carousel teams">
                            @foreach($data->tutor as $index => $tutor)
                                <div class="item">
                                    <div class="card text-center">
                                        <img src="{{asset($tutor->image)}}" class="card-img-top">
                                        <div class="card-body pb-1">
                                            <div class="img_border"></div>
                                            <h5 class="card-title">{{$tutor->name}}</h5>
                                            <p class="card-text">{{$tutor->about}}</p>
                                            <a href="{{route('explore.tutor',base64_encode($tutor->id))}}" class="float-right"><i class="fas fa-long-arrow-alt-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{route('explore.tutor')}}" class="btn viewmore">Expore</a>
                </div>
            </div>
        </section>
    @endif
    @if(count($data->testimonial) > 0)
        <section class="mt-5 pt-5 pb-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-4 newarival">
                        <h1 class="text_orange">
                            <span class="d-block">What</span>
                            members  
                            <span class="d-block">are saying</span>
                        </h1>
                        <h6 class="text-muted mb-4 mt-3 w-50">BY CHOOSING YOUR INSTRUMENT.</h6>
                        <a href="#" class="btn viewmore">Explore More</a>
                    </div>
                    <div class="col-12 col-md-6">
                        @foreach($data->testimonial as $key => $testimonial)
                            <div class="row m-0 testimonialbody">
                                <div class="col-6 col-md-6 p-0 testitext">
                                    <img src="{{asset('design/img/quote.png')}}" class="quote_icon">
                                    <p>{!! $testimonial->quote !!}</p>
                                    <h6>{{$testimonial->name}}<span>{{$testimonial->address}}</span></h6>
                                </div>
                                <div class="col-6 col-md-6 text-left">
                                    <img src="{{asset('design/img/testi-1.png')}}" class="w-100">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Frequently Asked Questions -->
    @if(count($data->faq) > 0)
        <section class="pt-5 pb-5 bg-light-blue faqs">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center title-inner">
                        <h1 class="mb-5 text-white">Frequently Asked Questions</h1>
                    </div>
                </div>
                <div>
                    <div id="accordion" class="accordion">
                        <div class="card mb-0 border-0 bg-transparent">
                            @foreach($data->faq as $key => $faq)
                                <div class="card-header collapsed" data-toggle="collapse" href="#collapseFaq{{$key}}">
                                    <a class="card-title text-white"> {{$faq->title}} </a>
                                </div>
                                <div id="collapseFaq{{$key}}" class="card-body collapse" data-parent="#accordion">
                                    <p class="text-white"> {!! $faq->description !!} </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Frequently Asked Questions End -->
@endsection