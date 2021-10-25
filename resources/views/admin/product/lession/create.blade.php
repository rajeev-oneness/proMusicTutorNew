@extends('layouts.auth.authMaster')
@section('title','Add Lession under '.$instrument->name)

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add Lession Under {{$instrument->name}} ({{$productSeries->title}})
                        <a class="headerbuttonforAdd" href="{{route('admin.product.series.lession.list',[$instrument->id,$productSeries->id])}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.product.series.lession.save',[$instrument->id,$productSeries->id])}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="instrumentId" value="{{$instrument->id}}">
                        @error('instrumentId')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                        <input type="hidden" name="productSeriesId" value="{{$productSeries->id}}">
                        @error('productSeriesId')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="image" class="col-form-label">Image:</label>
                                <input type="file" class="form-control form-control-sm @error('image') is-invalid @enderror" id="image" name="image" value="{{old('image')}}">
                                @error('image')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control form-control-sm @error('title') is-invalid @enderror" id="title" name="title" placeholder="Lession Title" value="{{old('title')}}">
                                @error('title')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="difficulty" class="col-form-label">Difficulty:</label>
                                <select class="form-control form-control-sm @error('difficulty') is-invalid @enderror" name="difficulty" id="difficulty">
                                    <option value="" hidden="" selected="">Select Difficulty</option>
                                    <option value="Easy" @if(old('difficulty') == 'Easy'){{('selected')}}@endif>Easy</option>
                                    <option value="Medium" @if(old('difficulty') == 'Medium'){{('selected')}}@endif>Medium</option>
                                    <option value="Hard" @if(old('difficulty') == 'Hard'){{('selected')}}@endif>Hard</option>
                                </select>
                                @error('difficulty')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="price_usd" class="col-form-label">USD:</label>
                                <input type="text" class="form-control form-control-sm @error('price_usd') is-invalid @enderror" id="price_usd" name="price_usd" placeholder="Price in USD" value="{{old('price_usd')}}" onkeypress="return isNumberKey(event);" maxlength="7">
                                @error('price_usd')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="price_euro" class="col-form-label">EURO:</label>
                                <input type="text" class="form-control form-control-sm @error('price_euro') is-invalid @enderror" id="price_euro" name="price_euro" placeholder="Price in EURO" value="{{old('price_euro')}}" onkeypress="return isNumberKey(event);" maxlength="7">
                                @error('price_euro')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="price_gbp" class="col-form-label">GBP:</label>
                                <input type="text" class="form-control form-control-sm @error('price_gbp') is-invalid @enderror" id="price_gbp" name="price_gbp" placeholder="Price in GBP" value="{{old('price_gbp')}}" onkeypress="return isNumberKey(event);" maxlength="7">
                                @error('price_gbp')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="preview_video" class="col-form-label">Preview video:</label>
                                <input type="file" class="form-control form-control-sm @error('preview_video') is-invalid @enderror" id="preview_video" name="preview_video" value="{{old('preview_video')}}">
                                @error('preview_video')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="video" class="col-form-label">Video:</label>
                                <input type="file" class="form-control form-control-sm @error('video') is-invalid @enderror" id="video" name="video_url" value="{{old('video')}}">
                                @error('video_url')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="keywords" class="col-form-label">Keywords:</label>
                                <input type="text" class="form-control form-control-sm @error('keywords') is-invalid @enderror" id="keywords" name="keywords" placeholder="PROVIDE A COMMA-SEPARATED LIST OF KEYWORDS" value="{{old('keywords')}}">
                                @error('keywords')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="genre" class="col-form-label">Genre:</label>
                                <select class="form-control form-control-sm @error('genre') is-invalid @enderror" name="genre" id="genre">
                                    <option value="" hidden="" selected="">Select Genre</option>
                                    @foreach($genre as $item)
                                        <option value="{{$item->id}}" {{old('genre') == $item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('genre')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="item_clean_url" class="col-form-label">Item clean URL:</label>
                                <input type="text" class="form-control form-control-sm @error('item_clean_url') is-invalid @enderror" id="item_clean_url" name="item_clean_url" placeholder="Item clean URL" value="{{old('item_clean_url')}}">
                                @error('item_clean_url')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="product_code" class="col-form-label">Product code:</label>
                                <input type="text" class="form-control form-control-sm @error('product_code') is-invalid @enderror" id="product_code" name="product_code" placeholder="Product code" value="{{old('product_code')}}">
                                @error('product_code')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">{{old('description')}}</textarea>
                            @error('description')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create</button>
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