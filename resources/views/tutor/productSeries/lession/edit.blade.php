@extends('layouts.auth.authMaster')
@section('title','Edit Lession under '.ucwords($instrument->name))
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Lession Under {{ucwords($instrument->name)}} ({{$productLession->product_series->title}})
                        <a class="headerbuttonforAdd" href="{{route('tutor.product.series.lession.list',[$instrument->id,$productLession->productSeriesId])}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('tutor.product.series.lession.update',[$instrument->id,$productLession->productSeriesId,$productLession->id])}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="instrumentId" value="{{$instrument->id}}">
                        @error('instrumentId')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                        <input type="hidden" name="productSeriesId" value="{{$productLession->productSeriesId}}">
                        <input type="hidden" name="productLessionId" value="{{$productLession->id}}">
                        @error('productSeriesId')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                        @error('productLessionId')<span class="text-danger" role="alert">{{$message}}</span>@enderror

                        <img src="{{asset($productLession->image)}}" height="200" width="200">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="image" class="col-form-label">Image:</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                @error('image')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Series Title" value="{{(old('title') ?? $productLession->title)}}">
                                @error('title')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="price" class="col-form-label">Price:</label>
                                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Price" value="{{(old('price') ?? $productLession->price)}}" onkeypress="return isNumberKey(event);" maxlength="7">
                                @error('price')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="difficulty" class="col-form-label">Difficulty:</label>
                                <select class="form-control @error('difficulty') is-invalid @enderror" name="difficulty" id="difficulty">
                                    <option value="" hidden="" selected="">Select Difficulty</option>
                                    <option value="Easy" @if((old('difficulty') ?? $productLession->difficulty) == 'Easy'){{('selected')}}@endif>Easy</option>
                                    <option value="Medium" @if((old('difficulty') ?? $productLession->difficulty) == 'Medium'){{('selected')}}@endif>Medium</option>
                                    <option value="Hard" @if((old('difficulty') ?? $productLession->difficulty) == 'Hard'){{('selected')}}@endif>Hard</option>
                                </select>
                                @error('difficulty')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="gbp" class="col-form-label">GBP:</label>
                                <input type="text" class="form-control @error('gbp') is-invalid @enderror" id="gbp" name="gbp" placeholder="GBP" value="{{(old('gbp') ?? zeroGoesToBlank($productLession->gbp))}}" onkeypress="return isNumberKey(event);" maxlength="7">
                                @error('gbp')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="price_usd" class="col-form-label">USD:</label>
                                <input type="text" class="form-control @error('price_usd') is-invalid @enderror" id="price_usd" name="price_usd" placeholder="Price in USD" value="{{(old('price_usd') ?? zeroGoesToBlank($productLession->price_usd))}}" onkeypress="return isNumberKey(event);" maxlength="7">
                                @error('price_usd')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="price_euro" class="col-form-label">EURO:</label>
                                <input type="text" class="form-control @error('price_euro') is-invalid @enderror" id="price_euro" name="price_euro" placeholder="Price in EURO" value="{{(old('price_euro') ?? zeroGoesToBlank($productLession->price_euro))}}" onkeypress="return isNumberKey(event);" maxlength="7">
                                @error('price_euro')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="keywords" class="col-form-label">Keywords:</label>
                                <input type="text" class="form-control @error('keywords') is-invalid @enderror" id="keywords" name="keywords" placeholder="PROVIDE A COMMA-SEPARATED LIST OF KEYWORDS" value="{{(old('keywords') ?? $productLession->keywords)}}">
                                @error('keywords')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="genre" class="col-form-label">Genre:</label>
                                <select class="form-control @error('genre') is-invalid @enderror" name="genre" id="genre">
                                    <option value="" hidden="" selected="">Select Genre</option>
                                    @foreach($genre as $item)
                                        <option value="{{$item->id}}" {{(old('genre') ?? $productLession->genre) == $item->id ? 'selected' : ''}}>{{ ucwords($item->name) }}</option>
                                    @endforeach
                                </select>
                                @error('genre')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="item_clean_url" class="col-form-label">Item clean URL:</label>
                                <input type="text" class="form-control @error('item_clean_url') is-invalid @enderror" id="item_clean_url" name="item_clean_url" placeholder="Item clean URL" value="{{(old('item_clean_url') ?? $productLession->item_clean_url)}}">
                                @error('item_clean_url')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="product_code" class="col-form-label">Product code:</label>
                                <input type="text" class="form-control @error('product_code') is-invalid @enderror" id="product_code" name="product_code" placeholder="Product code" value="{{(old('product_code') ?? $productLession->product_code)}}">
                                @error('product_code')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">{{(old('description') ?? $productLession->description)}}</textarea>
                            @error('description')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                        </div>

                        <div class="form-group">
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
    <script type="text/javascript">
        CKEDITOR.replace('description');  
    </script>
@stop
@endsection