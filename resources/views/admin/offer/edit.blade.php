@extends('layouts.auth.authMaster')
@section('title','Offer Edit')

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Offer
                        <a class="headerbuttonforAdd" href="{{route('admin.master.offer.list')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.master.offer.update', $offer->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <img src="{{asset($offer->image)}}" alt="offer-image" height="100">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="image" class="col-form-label">Image:</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                @error('image')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{(old('title') ?? $offer->title)}}">
                                @error('title')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="price_gbp" class="col-form-label">Price GBP:</label>
                                <input type="text" class="form-control @error('price_gbp') is-invalid @enderror" id="price_gbp" name="price_gbp" placeholder="Price GBP" value="{{(old('price_gbp') ?? $offer->price_gbp)}}" 
                                {{-- onkeypress="return isNumberKey(event)" --}}
                                >
                                @error('price_gbp')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="price_usd" class="col-form-label">Price USD:</label>
                                <input type="text" class="form-control @error('price_usd') is-invalid @enderror" id="price_usd" name="price_usd" placeholder="Price USD" value="{{(old('price_usd') ?? $offer->price_usd)}}">
                                @error('price_usd')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="price_eur" class="col-form-label">Price EUR:</label>
                                <input type="text" class="form-control @error('price_eur') is-invalid @enderror" id="price_eur" name="price_eur" placeholder="Price EUR" value="{{(old('price_eur') ?? $offer->price_euro)}}">
                                @error('price_eur')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label for="description" class="col-form-label">Description:</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">{{(old('description') ?? $offer->description)}}</textarea>
                                @error('description')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label for="offer_description" class="col-form-label">Offer description:</label>
                                <textarea class="form-control @error('offer_description') is-invalid @enderror" id="offer_description" name="offer_description" placeholder="Offer description">{{(old('offer_description') ?? $offer->offer_description)}}</textarea>
                                @error('offer_description')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <hr>

                        <h4 class="mb-0">Series</h4>
                        @php $offerSeries = $offer->offer_series->pluck('series_id')->toArray();
                        @endphp
                        <label for="offer_description" class="col-form-label">Tap <em>ctrl</em> & select multiple series</label>
                        <select name="seriesId[]" id="" class="form-control" multiple>
                            <option value="" hidden>Select</option>
                            @foreach ($series as $item)
                                <option value="{{$item->id}}" @if(in_array($item->id,$offerSeries)){{('selected')}}@endif>{{$item->title}}</option>
                            @endforeach
                        </select>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script type="text/javascript" src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
@stop
@endsection