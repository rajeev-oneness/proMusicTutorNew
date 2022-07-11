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
    @php
        $instrumentParameter = [];
        if($data->instrument){
            $instrumentParameter = [
                'instrumentId' => $data->instrument->id,
                'instrumentName' => $data->instrument->name,
            ];
        }
    @endphp

    @if(count($data->category) > 0)
        <section class="pt-5 pb-5 header_padding series_list">
            <div class="container">
                <div class="row mx-0">
                    <div class="col-12 mb-3">
                        <div class="d-flex">
                            <a href="{{URL::to('/')}}">Home</a>
                            <div class="arrow">></div>
                            <a href="{{route('product.series',$instrumentParameter)}}" class="{{ (request()->input('categoryId') && request()->input('categoryName')) ? '' : 'active' }}">{{$instrumentParameter['instrumentName']}}</a>
                            @if (request()->input('categoryId') && request()->input('categoryName'))
                                <div class="arrow">></div>
                                <a href="#" class="active">{{request()->input('categoryName')}}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mx-0">
                    <div class="col-12 title-inner">
                        <h1 class="mb-3">{{ $req->instrumentName }} {{ ($req->categoryName) ? '- '.$req->categoryName : '' }}</h1>
                        @if (request()->input('categoryId') && request()->input('categoryName'))
                            <div class="mb-3 text-muted">{!! $data->categoryDetails->description !!}</div>
                        @else
                            <div class="mb-3 text-muted">{!! $data->instrument->description !!}</div>
                        @endif
                    </div>
                </div>
                <div class="row m-0">
                    <div class="col-12">
                        <h5 class="text-muted mb-3">Choose Your Category</h5>
                    </div>
                    @foreach($data->category as $index => $cat)
                        @php
                            $categoryParameter = $instrumentParameter;
                            $categoryParameter['categoryId'] = $cat->id;
                            $categoryParameter['categoryName'] = $cat->name;
                        @endphp
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <div class="card border-0 {{ (request()->input('categoryName') == $cat->name) ? 'active' : ''}}">
                                <img src="{{asset($cat->image)}}">
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
                @if(count($data->guitarSeries) > 0)
                <div class="text-center title-inner">
                    @if (request()->input('categoryId') && request()->input('categoryName'))
                        <h1 class="mb-5">All Series Related to {{request()->input('categoryName')}}</h1>
                    @elseif (!empty($req->difficulty) || !empty($req->search) || !empty($req->currency))
                        <h1 class="mb-5">Filtered Series Related to {{request()->input('instrumentName')}}</h1>
                    @else
                        <h1 class="mb-5">All Series @if($data->instrument){{' Related to '.$data->instrument->name}}@endif</h1>
                    @endif
                </div>
                <div class="row mb-3">
                <div class="col-12 col-md-12 filter_section">
                    <form method="post" action="{{route('product.series',$instrumentParameter)}}" class="w-100">
                        @csrf
                        <div class="w-100 d-flex justify-content-end filter-flex">
                            <div class="form-group mb-0 mr-2">
                                <select class="form-control form-control-sm" name="currency">
                                    <option value="" disabled="">Currency</option>
                                    <option selected value="usd">$ USD</option>
                                    <option {{($req->currency == 'eur') ? 'selected' : ''}} value="eur">€ EUR</option>
                                    <option {{($req->currency == 'gbp') ? 'selected' : ''}} value="gbp">£ GBP</option>
                                </select>
                            </div>
                            <div class="form-group mb-0 mr-2">
                                <select class="form-control form-control-sm" name="difficulty">
                                    <option value="" selected="" disabled="">Difficulty</option>
                                    <option {{($req->difficulty == 'Easy') ? 'selected' : ''}} value="Easy">Easy</option>
                                    <option {{($req->difficulty == 'Medium') ? 'selected' : ''}} value="Medium">Medium</option>
                                    <option {{($req->difficulty == 'Hard') ? 'selected' : ''}} value="Hard">Hard</option>
                                </select>
                            </div>
                            <div class="form-group mb-0 mr-2">
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search keyword" value="{{$req->search}}">
                            </div>
                            <div class="form-group mb-0 mr-2">
                                <button type="submit" name="" class="btn buyfull">Apply</button>
                                <a href="{{route('product.series',$instrumentParameter)}}" class="btn detail">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <div class="col-12 text-center title-inner">
                    <h1 class="mb-5">All Series @if($data->instrument){{' Related to '.$data->instrument->name}}@endif</h1>
                </div>
                @endif
            </div>

            @if(count($data->guitarSeries) > 0)
                <div class="row m-0 series-row">
                    @foreach($data->guitarSeries as $key => $series)
                        <div class="col-12 col-sm-6 col-lg-4 single-series">
                            <div class="card border-0 bg-transparent more-course">
                                <img src="{{asset($series->image)}}" class="card-img-top">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{$series->title}}</h5>
                                    <p class="card-text">{!! words($series->description,200) !!}</p>
                                    <?php $seriesPrice = calculateLessionPrice($series, $data->currency); ?>
                                    @guest
                                        <a href="javascript:void(0)" class="btn buyfull " onclick="alert('please login to continue')">BUY FULL SERIES - {{currencySymbol($data->currency)}} {{$seriesPrice}}</a>
                                    @else
                                        @if($series->userPurchased)
                                            <a href="javascript:void(0)" class="btn purchased-Full ">Already Purchased</a>
                                        @else
                                            <a href="javascript:void(0)" class="btn buyfull " onclick="stripePaymentStart('{{$seriesPrice}}','{{route('after.purchase.guitar_series',$series->id)}}', '{{$data->currency}}');">BUY FULL SERIES - {{currencySymbol($data->currency)}} {{$seriesPrice}}</a>

                                            <!-- Add To Cart -->
                                            <a class="btn btn-lg" onclick="addOrRemoveUserProductCart('{{$user->id}}','series','{{$series->id}}','add','{{$data->currency}}')"><i class="fas fa-cart-plus"></i></a>
                                        @endif
                                    @endguest
                                </div>
                                <div class="card-footer d-flex border-0 p-0">
                                    <a href="{{route('product.series.details',$series->id)}}" class="btn detail col-12 col-md-6">Details</a>
                                    <a href="javascript:void(0)" class="btn preview col-12 col-md-6" onclick="previewVideo('{{$series->id}}', '{{asset($series->video_url)}}', '{{$series->title}}')">PREVIEW <i class="fa fa-play ml-2"></i></a>
                                    {{-- @guest
                                        <a href="javascript: void(0)" class="btn preview col-12 col-md-6 wishlist" onclick="walert('please login to continue')"> <i class="fa fa-heart"></i> WISHLIST</a>
                                    @else
                                        @if ($series->userWishlisted)
                                            <a href="javascript: void(0)" class="btn preview col-12 col-md-6 wishlist wishlisted" onclick="wishlistToggle({{$series->id}}, 'series')"> <i class="fa fa-heart"></i> WISHLISTED</a>
                                        @else
                                            <a href="javascript: void(0)" class="btn preview col-12 col-md-6 wishlist not-wishlisted" onclick="wishlistToggle({{$series->id}}, 'series')"> <i class="fa fa-heart"></i> WISHLIST</a>
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

                <div class="paginate">
                    {{$data->guitarSeries->appends($_GET)->links()}}
                </div>
                <!-- <div class="text-center mt-5">
                    <a href="javascript:void(0)" class="btn viewmore">EXPLORE MORE</a>
                </div> -->
            @else
                <div class="text-center">
                    <p class="text-muted mb-4">No Series found</p>
                    <a href="{{route('product.series',$instrumentParameter)}}" class="btn btn-light border shadow"><i class="fas fa-chevron-left"></i> Go Back</a>
                </div>
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