@extends('layouts.master')
@section('title','Product Series')
@section('content')

    <?php $totalPrice = calculateLessionPrice($data->lession); ?>
    <section class="pt-0 pt-md-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 shadow-lg p-0 mb-4 mb-md-0">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="{{asset($data->video_url)}}" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="row m-0">
                        <h5 class="col-6 pt-2 pl-0 pl-md-3">{{$data->title}}</h5>
                        @guest
                            <a href="javascript:void(0)" class="col-6 col-md-5 ml-auto buyfull" onclick="alert('please login to continue')">BUY FULL SERIES - £ {{$totalPrice}}</a>
                        @else
                            @if($data->userPurchased)
                                <a href="javascript:void(0)" class="btn purchased-Full mb-3">Already Purchased</a>
                            @else
                                <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="stripePaymentStart('{{$totalPrice}}','{{route('after.purchase.guitar_series',$data->id)}}');">BUY FULL SERIES - $  {{$totalPrice}}</a>
                            @endif
                        @endguest

                        @guest
                            <a href="javascript: void(0)" class="btn preview col-6 wishlist" onclick="alert('please login to continue')"> <i class="fa fa-heart"></i></a>
                        @else
                            @if ($data->userWishlisted)
                                <a href="javascript: void(0)" class="btn wishlist wishlisted rounded-0 mb-3" onclick="wishlistToggle({{$req->seriesId}}, 'series')" title="Wishlisted"> <i class="fa fa-heart text-light pe-none"></i></a>
                            @else
                                <a href="javascript: void(0)" class="btn wishlist not-wishlisted rounded-0 mb-3" onclick="wishlistToggle({{$req->seriesId}}, 'series')" title="Wishlist now"> <i class="fa fa-heart text-light pe-none"></i></a>
                            @endif
                        @endguest

                    </div>
                    <div class="col-12 pt-4 pl-0 pl-md-3">
                        <h6 class="mb-3">Series Description</h6>
                        <p>{!! words($data->description,600) !!}</p>
                    </div>
                </div>
                <?php $tutor = $data->author;?>
                @if($tutor)
                    <div class="row m-0 mt-5 col-12 p-0 pl-3 pl-md-0">
                        <h6>TUTOR: <a href="{{route('explore.tutor',[base64_encode($tutor->id),'tutor'=>$tutor->name])}}" style="font-size: 18px;"><span style="color: #e40054 !important;">{{strtoupper($tutor->name)}}</span></a></h6>
                    </div>
                    <div class="row m-0 mt-4 col-12 p-0 pl-3 pl-md-0">
                        <h6>DIFFICULTY: <span style="color: #e40054 !important;">{{strtoupper($data->difficulty)}}</span></h6>
                    </div>
                    <div class="col-12 mt-4 p-3 p-md-0">
                        <h6 class="mb-3">Tutor Description</h6>
                        <p>{!! words($tutor->about,900) !!}</p>
                    </div>
                    <!-- <div class="row mt-5 m-0 col-12 p-0 pl-3 pl-md-0">
                        <ul class="music-cata ">
                            <li><a href="javascript:void(0)" class="active">MICKY MOODY'S VIDEO BIO</a></li>
                            <li><a href="javascript:void(0)">HECK OUT MICKY MOODY'S PROFILE </a></li>
                            <li><a href="javascript:void(0)">ROCK</a></li>
                            <li><a href="javascript:void(0)"> MEDIUM</a></li>
                        </ul>
                    </div> -->
                @endif
            </div>
        </div>
    </section>

    <!-- Guitar Series Lession -->
    <?php $lessions = $data->lession; ?>

    @if(count($lessions) > 0)
        <section class="pt-5 pb-5 mb-5 bg-light">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="d-flex">
                            <h5 class="pt-2">LESSONS</h5>
                            @guest
                                <a href="javascript:void(0)" class="buyfull ml-3 ml-md-5" onclick="alert('please login to continue')">BUY FULL SERIES - £ {{$totalPrice}}</a>
                            @else
                                @if($data->userPurchased)
                                    <a href="javascript:void(0)" class="purchased-Full ml-3 ml-md-5">Already Purchased</a>
                                @else
                                    <a href="javascript:void(0)" class="buyfull ml-3 ml-md-5" onclick="stripePaymentStart('{{$totalPrice}}','{{route('after.purchase.guitar_series',$data->id)}}');">BUY FULL SERIES - $  {{$totalPrice}}</a>
                                @endif
                            @endguest
                        </div>
                    </div>
                    <div class="col-6 text-right pt-2">
                        <!-- Filter -->
                        <form method="post" action="{{route('product.series.details',$data->id)}}" class="form-inline justify-content-end">
                            @csrf
                            <div class="form-group mr-3">
                                <label class="form-label mr-3">Select Difficulty</label>
                                <select class="form-control form-control-sm" name="difficulty">
                                    <option value="" selected="" hidden="">Difficulty</option>
                                    <option {{($req->difficulty == 'Easy') ? 'selected' : ''}} value="Easy">Easy</option>
                                    <option {{($req->difficulty == 'Medium') ? 'selected' : ''}} value="Medium">Medium</option>
                                    <option {{($req->difficulty == 'Hard') ? 'selected' : ''}} value="Hard">Hard</option>
                                </select>
                            </div>
                            <button type="submit" name="" class="btn btn-sm btn-primary mr-3">Apply</button>
                            <a href="{{route('product.series.details',$data->id)}}" class="btn btn-sm btn-light border">Reset</a>
                        </form>
                        <!-- Filter end -->
                    </div>
                </div>
                <div class="row m-0">
                    @foreach($lessions as $key => $less)
                        <div class="card col-12 p-0 mb-3">
                            <div class="row no-gutters">
                                <div class="col-md-4 position-relative">
                                    <img src="{{asset($less->image)}}" class="card-img">
                                    <div class="difficulty_section right-0">
                                        {{$less->difficulty}}
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body position-relative">
                                        <h5 class="card-title">{{$less->title}}</h5>
                                        <p class="card-text">{!! words($less->description,1000) !!}</p>
                                        <div class="float-right buynow-btn">
                                            @guest
                                                <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="alert('please login to continue')">Buy Now - £ {{$less->price}}</a>
                                            @else
                                                @if(userLessionPurchased($less))
                                                    <a href="javascript:void(0)" class="purchased-Full btn">Already Purchased</a>
                                                @else
                                                    <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="stripePaymentStart('{{$less->price}}','{{route('after.purchase.guitar_lession_series',$less->id)}}');">Buy Now - $  {{$less->price}}</a>
                                                @endif
                                            @endguest
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- <div class="text-center mt-5">
                    <a href="javascript:void(0)" class="btn viewmore">EXPLORE MORE</a>
                </div> -->
            </div>
        </section>
    @endif

    <!-- Other Guitar Series You may Like -->
    @if(count($data->otherGuitarSeries) > 0)
        <section class="pt-2 mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center title-inner">
                        <h1 class="mb-5">Other Series You May Like</h1>
                    </div>
                </div>
                <div class="row m-0">
                    @foreach($data->otherGuitarSeries as $index => $otherSeries)
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="card border-0 bg-transparent more-course">
                                <img src="{{asset($otherSeries->image)}}" class="card-img-top" alt="...">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{$otherSeries->title}}</h5>
                                    <p class="card-text">{!! words($otherSeries->description,200) !!}</p>
                                    <?php $seriesPrice = calculateLessionPrice($otherSeries->lession); ?>
                                    @guest
                                        <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="alert('please login to continue')">BUY FULL SERIES - $  {{$seriesPrice}}</a>
                                    @else
                                        @if($otherSeries->userPurchased)
                                            <a href="javascript:void(0)" class="btn purchased-Full mb-3">Already Purchased</a>
                                        @else
                                            <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="stripePaymentStart('{{$seriesPrice}}','{{route('after.purchase.guitar_series',$otherSeries->id)}}');">BUY FULL SERIES - $  {{$seriesPrice}}</a>
                                        @endif
                                    @endif
                                </div>
                                <div class="card-footer d-flex border-0 p-0">
                                    <a href="{{route('product.series.details',$otherSeries->id)}}" class="btn detail col-6">Details</a>
                                    <a href="javascript:void(0)" class="btn preview col-6">PREVIEW</a>
                                </div>
                                <div class="difficulty_section right-0">
                                    {{$otherSeries->difficulty}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@section('script')
<script type="text/javascript"></script>
@endsection