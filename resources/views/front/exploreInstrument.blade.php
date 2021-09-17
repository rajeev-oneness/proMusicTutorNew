@extends('layouts.master')
@section('title','Instrument List')
@section('content')
<section class="pt-3 pt-md-5 pb-3 pb-md-5 instrument_list bg-light">
        <div class="container">
            <div class="row m-0 my_teams">
                <div class="col-12 text-center">
                    <h1 class="mb-5">Instrument List</h1>
                </div>
            </div>
            <div class="row justify-content-between m-0 mb-5 align-content-center align-items-center">
                <div class="col-12 col-lg-4">
                    <ul class="bredcamb">
                        <li><a href="{{route('welcome')}}">Home</a></li>
                        <li>/</li>
                        <li><a href="javascript:void(0)" class="active">Instrument</a></li>
                    </ul>
                </div>
                <form class="col-12 col-lg-4">
                  <div class="form-group row m-0 sortby">
                    <label class="col-sm-4 col-form-label">Sprt By</label>
                    <div class="col-sm-8">
                      <select class="form-control form-control-sm">
                        <option value="featured">Featured</option>
                        <option value="newest">Newest</option>
                        <option value="bestselling">Best Selling</option>
                        <option value="alphaasc" selected="">A - Z</option>
                        <option value="alphadesc">Z - A</option>
                        <option value="avgcustomerreview">Reviews</option>
                        <option value="priceasc">Price: Low to High</option>
                        <option value="pricedesc">Price: High to Low</option>
                      </select>
                    </div>
                  </div>
                </form>
            </div>
            <div class="row m-0">
                @foreach($data->instruments as $key => $instrument)
                    <div class="col-12 col-lg-3 mb-4">
                        <div class="card border-0 item">
                            <a href="{{route('product.series',['instrumentId'=>$instrument->id,'instrumentName' => $instrument->name])}}">
                                <div class="image_item" style="background: url('{{asset($instrument->image)}}');"></div>
                                <div class="text-item">
                                    <h5 class="mb-2">{{$instrument->name}}</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
                <!-- <div class="col-12 text-center mt-5">
                    <a href="#" class="btn viewmore">View More</a>
                </div> -->
            </div>
        </div>
    </section>
@section('script')
    <script type="text/javascript"></script>
@stop
@endsection