@extends('layouts.auth.authMaster')
@section('title','Edit Product Series')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Product Series
                        <a class="headerbuttonforAdd" href="{{route('tutor.product.series')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('tutor.product.series.update',$productSeries->id)}}" enctype="multipart/form-data">
                        <input type="hidden" name="productSeriesId" value="{{$productSeries->id}}">
                        @error('productSeriesId')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                        @csrf
                        <div class="row">
                            <img src="{{asset($productSeries->image)}}" height="250" width="250">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="category" class="col-form-label">Category:</label>
                                <select class="form-control @error('category') is-invalid @enderror" name="category" id="category">
                                    <option value="" hidden="" selected="">Select Category</option>
                                    @foreach($category as $cat)
                                        <option value="{{$cat->id}}" {{($productSeries->categoryId == $cat->id ? 'selected':'')}}>{{$cat->name}}</option>
                                    @endforeach
                                </select>
                                @error('category')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="image" class="col-form-label">Change Image:</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                @error('image')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Series Title" value="{{$productSeries->title}}">
                                @error('title')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="media_link" class="col-form-label">Media Link:</label>
                                <input type="text" class="form-control @error('media_link') is-invalid @enderror" id="media_link" name="media_link" placeholder="Video Media Link" value="{{$productSeries->video_url}}">
                                @error('media_link')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="genre" class="col-form-label">Genre:</label>
                                <select class="form-control @error('genre') is-invalid @enderror" name="genre" id="genre" required>
                                    <option value="" hidden="" selected="">Select Genre</option>
                                    @foreach($genre as $item)
                                        <option value="{{$item->id}}" {{ $productSeries->genre == $item->id ? 'selected' : '' }}>{{ ucwords($item->name) }}</option>
                                    @endforeach
                                </select>
                                @error('genre')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="difficulty" class="col-form-label">Difficulty:</label>
                                <select class="form-control @error('difficulty') is-invalid @enderror" name="difficulty" id="difficulty">
                                    <option value="" hidden="" selected="">Select Difficulty</option>
                                    <option value="easy" {{ $productSeries->difficulty == 'easy' ? 'selected' : '' }}>Easy</option>
                                    <option value="medium" {{ $productSeries->difficulty == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="hard" {{ $productSeries->difficulty == 'hard' ? 'selected' : '' }}>Hard</option>
                                </select>
                                @error('difficulty')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="gbp" class="col-form-label">GBP:</label>
                                <input type="text" class="form-control @error('gbp') is-invalid @enderror" id="gbp" name="gbp" placeholder="GBP" value="{{$productSeries->gbp}}">
                                @error('gbp')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="price_usd" class="col-form-label">USD:</label>
                                <input type="text" class="form-control @error('price_usd') is-invalid @enderror" id="price_usd" name="price_usd" placeholder="Price in USD" value="{{$productSeries->price_usd}}">
                                @error('price_usd')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="price_euro" class="col-form-label">EURO:</label>
                                <input type="text" class="form-control @error('price_euro') is-invalid @enderror" id="price_euro" name="price_euro" placeholder="Price in EURO" value="{{$productSeries->price_euro}}">
                                @error('price_euro')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="item_clean_url">Item clean URL</label>
                                <input type="text" name="item_clean_url" id="item_clean_url" placeholder="Item clean URL" class="form-control" value="{{ $productSeries->item_clean_url }}">
                                @error('item_clean_url')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="seo_meta_description">SEO Meta Description</label>
                                <input type="text" name="seo_meta_description" id="seo_meta_description" placeholder="SEO meta description" class="form-control" value="{{ $productSeries->seo_meta_description }}">
                                @error('seo_meta_description')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="seo_meta_keywords">SEO Meta Keywords</label>
                                <input type="text" name="seo_meta_keywords" id="seo_meta_keywords" placeholder="SEO meta keywords" class="form-control" value="{{ $productSeries->seo_meta_keywords }}">
                                @error('seo_meta_keywords')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">{{$productSeries->description}}</textarea>
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