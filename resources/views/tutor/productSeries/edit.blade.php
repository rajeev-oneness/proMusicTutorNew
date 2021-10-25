@extends('layouts.auth.authMaster')
@section('title','Edit Product Series')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit {{ucwords($instrument->name)}} Series
                        <a class="headerbuttonforAdd" href="{{route('tutor.product.series.list',[$instrument->id])}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('tutor.product.series.update',[$instrument->id,$productSeries->id])}}" enctype="multipart/form-data">
                        <input type="hidden" name="instrumentId" value="{{$instrument->id}}">
                        @error('instrumentId')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                        <input type="hidden" name="productSeriesId" value="{{$productSeries->id}}">
                        @error('productSeriesId')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 image-upload-wrapper">
                                <img src="{{asset($productSeries->image)}}" height="200" width="250">                             
                                <input type="file" class="form-control form-control-sm @error('image') is-invalid @enderror" id="image" name="image">
                                <button><i class="fas fa-pencil-alt"></i></button>
                                @error('image')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-5 image-upload-wrapper ml-3">
                                @if ($productSeries->video_url)
                                <video height="200" muted controls>
                                    <source src="{{asset($productSeries->video_url)}}">
                                </video>
                                @else
                                <p class="text-danger">No video uploaded</p>
                                @endif
                                <br>
                                <input type="file" class="form-control form-control-sm @error('media_link') is-invalid @enderror" id="media_link" name="media_link" value="">
                                <button><i class="fas fa-pencil-alt"></i></button>
                                @error('media_link')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control form-control-sm @error('title') is-invalid @enderror" id="title" name="title" placeholder="Series Title" value="{{(old('title') ? old('title') : $productSeries->title)}}">
                                @error('title')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="category" class="col-form-label">Category:</label>
                                <select class="form-control form-control-sm @error('category') is-invalid @enderror" name="category" id="category">
                                    <option value="" hidden="" selected="">Select Category</option>
                                    @foreach($category as $cat)
                                        <option value="{{$cat->id}}" {{(old('category') ? old('category') : $productSeries->categoryId)== $cat->id?'selected':''}}>{{$cat->name}}</option>
                                    @endforeach
                                </select>
                                @error('category')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="genre" class="col-form-label">Genre:</label>
                                <select class="form-control form-control-sm @error('genre') is-invalid @enderror" name="genre" id="genre">
                                    <option value="" hidden="" selected="">Select Genre</option>
                                    @foreach($genre as $item)
                                        <option value="{{$item->id}}" {{(old('genre') ? old('genre') : $productSeries->genre) == $item->id ? 'selected' : ''}}>{{ ucwords($item->name) }}</option>
                                    @endforeach
                                </select>
                                @error('genre')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="difficulty" class="col-form-label">Difficulty:</label>
                                <select class="form-control form-control-sm @error('difficulty') is-invalid @enderror" name="difficulty" id="difficulty">
                                    <option value="" hidden="" selected="">Select Difficulty</option>
                                    <option value="Easy" @if((old('difficulty') ?? $productSeries->difficulty) == 'Easy'){{('selected')}}@endif>Easy</option>
                                    <option value="Medium" @if((old('difficulty') ?? $productSeries->difficulty) == 'Medium'){{('selected')}}@endif>Medium</option>
                                    <option value="Hard" @if((old('difficulty') ?? $productSeries->difficulty) == 'Hard'){{('selected')}}@endif>Hard</option>
                                </select>
                                @error('difficulty')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="price_usd" class="col-form-label">USD:</label>
                                <input type="text" class="form-control form-control-sm @error('price_usd') is-invalid @enderror" id="price_usd" name="price_usd" placeholder="Price in USD" value="{{(old('price_usd') ? old('price_usd') : zeroGoesToBlank($productSeries->price_usd))}}" onkeypress="return isNumberKey(event);" maxlength="7">
                                @error('price_usd')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="price_euro" class="col-form-label">EURO:</label>
                                <input type="text" class="form-control form-control-sm @error('price_euro') is-invalid @enderror" id="price_euro" name="price_euro" placeholder="Price in EURO" value="{{(old('price_euro') ? old('price_euro') : zeroGoesToBlank($productSeries->price_euro))}}" onkeypress="return isNumberKey(event);" maxlength="7">
                                @error('price_euro')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="price_gbp" class="col-form-label">GBP:</label>
                                <input type="text" class="form-control form-control-sm @error('price_gbp') is-invalid @enderror" id="price_gbp" name="price_gbp" placeholder="Price in GBP" value="{{(old('price_gbp') ? old('price_gbp') : zeroGoesToBlank($productSeries->price_gbp))}}" onkeypress="return isNumberKey(event);" maxlength="7">
                                @error('price_gbp')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="item_clean_url" class="col-form-label">Item clean URL</label>
                                <input type="url" name="item_clean_url" id="item_clean_url" placeholder="Item clean URL" class="form-control form-control-sm" value="{{(old('item_clean_url') ? old('item_clean_url') : $productSeries->item_clean_url)}}">
                                @error('item_clean_url')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="seo_meta_description" class="col-form-label">SEO Meta Description</label>
                                <input type="text" name="seo_meta_description" id="seo_meta_description" placeholder="SEO meta description" class="form-control form-control-sm" value="{{(old('seo_meta_description') ? old('seo_meta_description') : $productSeries->seo_meta_description)}}">
                                @error('seo_meta_description')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="seo_meta_keywords" class="col-form-label">SEO Meta Keywords</label>
                                <input type="text" name="seo_meta_keywords" id="seo_meta_keywords" placeholder="PROVIDE A COMMA-SEPARATED LIST OF KEYWORDS" class="form-control form-control-sm" value="{{(old('seo_meta_keywords') ? old('seo_meta_keywords') : $productSeries->seo_meta_keywords)}}">
                                @error('seo_meta_keywords')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">{{(old('description') ? old('description') : $productSeries->description)}}</textarea>
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