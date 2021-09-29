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
                                    <option>$ - GBP</option>
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
                <div class="col-6 text-right pt-2">
                    <form method="post" action="{{route('product.series',$instrumentParameter)}}" class="form-inline justify-content-end">
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
                            <a href="{{route('product.series',$instrumentParameter)}}" class="btn btn-sm btn-light border">Reset</a>
                    </form>
                </div>
            </div>
            @if(count($data->guitarSeries) > 0)
                <div class="row m-0 series-row">
                    @foreach($data->guitarSeries as $key => $series)
                        <div class="col-12 col-sm-6 col-md-4 single-series">
                            <div class="card border-0 bg-transparent more-course">
                                <img src="{{asset($series->image)}}" class="card-img-top">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{$series->title}}</h5>
                                    <p class="card-text">{!! words($series->description,200) !!}</p>
                                    <?php $seriesPrice = calculateLessionPrice($series->lession); ?>
                                    @guest
                                        <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="alert('please login to continue')">BUY FULL SERIES - $ {{$seriesPrice}}</a>
                                    @else
                                        @if($series->userPurchased)
                                            <a href="javascript:void(0)" class="btn purchased-Full mb-3">Already Purchased</a>
                                        @else
                                            <a href="javascript:void(0)" class="btn buyfull mb-3" onclick="stripePaymentStart('{{$seriesPrice}}','{{route('after.purchase.guitar_series',$series->id)}}');">BUY FULL SERIES - $  {{$seriesPrice}}</a>
                                        @endif
                                    @endguest
                                </div>
                                @php
                                    $name = "'".$series->title."'";
                                    $videoPath = "'".$series->video_url."'";
                                @endphp
                                <div class="card-footer d-flex border-0 p-0">
                                    <a href="{{route('product.series.details',$series->id)}}" class="btn detail col-6">Details</a>
                                    <a href="javascript:void(0)" class="btn preview col-6" onclick="previewVideo({{$series->id}}, {{$videoPath}}, {{$name}})">PREVIEW</a>
                                    {{-- @guest
                                        <a href="javascript: void(0)" class="btn preview col-6 wishlist" onclick="walert('please login to continue')"> <i class="fa fa-heart"></i> WISHLIST</a>
                                    @else
                                        @if ($series->userWishlisted)
                                            <a href="javascript: void(0)" class="btn preview col-6 wishlist wishlisted" onclick="wishlistToggle({{$series->id}}, 'series')"> <i class="fa fa-heart"></i> WISHLISTED</a>
                                        @else
                                            <a href="javascript: void(0)" class="btn preview col-6 wishlist not-wishlisted" onclick="wishlistToggle({{$series->id}}, 'series')"> <i class="fa fa-heart"></i> WISHLIST</a>
                                        @endif
                                    @endguest --}}
                                </div>
                            </div>
                            <div class="difficulty_section">
                                {{$series->difficulty}}
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
<script type="text/javascript">
    // function wishlistToggle(id, type) {
    //     var $this = event.target;
    //     $.ajax({
    //         url : "{{route('front.wishlist.toggle')}}",
    //         method : "POST",
    //         dataType : "json",
    //         data : {id : id, type : type, _token : "{{ csrf_token() }}" },
    //         beforeSend : function() {
    //             $($this).html('<i class="fa fa-spinner"></i> Loading').addClass('pe-none');
    //         },
    //         success : function(result) {
    //             if (result.code == 1) {
    //                 $($this).html('<i class="fa fa-heart"></i> WISHLISTED').removeClass('pe-none not-wishlisted').addClass('wishlisted');
    //             } else {
    //                 $($this).html('<i class="fa fa-heart"></i> WISHLIST').removeClass('pe-none wishlisted').addClass('not-wishlisted');
    //             }
    //         }
    //     });
    // }
</script>
@endsection