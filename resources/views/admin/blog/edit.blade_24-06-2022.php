@extends('layouts.auth.authMaster')
@section('title','Edit Blogs')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Blog
                        <a class="headerbuttonforAdd" href="{{route('admin.blog.data.list')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.blog.data.update',$data->id)}}" enctype="multipart/form-data" class="row">
                        @csrf
                        <input type="hidden" name="blogId" value="{{$data->id}}">
                        <div class="form-group col-lg-6">
                            <img src="{{asset($data->image)}}" height="300" width="300">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="image" class="col-form-label">Update Image:</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="title" class="col-form-label">Title:</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{(old('title') ?? $data->title)}}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @php
                            $selectedCategory = (old('category') ?? $data->blogCategoryId);
                            $selectedTags = ($data->tags != '' ? explode(',',$data->tags) : []);
                        @endphp

                        <div class="form-group col-lg-6">
                            <label for="category" class="col-form-label">Category:</label>
                            <select class="sumoSelect form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                                @foreach($data->category as $catIndex => $catValue)
                                    <option value="{{$catValue->id}}" @if($selectedCategory == $catValue->id){{('selected')}}@endif>{{$catValue->title}}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group col-lg-6">
                            <label for="tags" class="col-form-label">Tags:</label>
                            <select class="sumoSelectTag form-control @error('tags') is-invalid @enderror" id="tags" name="tags[]" multiple required>
                                @foreach($data->tagsData as $tagIndex => $tagValue)
                                    <option value="{{$tagValue->id}}" @if(in_array($tagValue->id,$selectedTags)){{('selected')}}@endif>{{$tagValue->title}}</option>
                                @endforeach
                            </select>
                            @error('tags')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea required class="form-control form-control-sm @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">{{(old('description') ?? $data->description)}}</textarea>
                            @error('description')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                        </div>

                        <div class="form-group col-lg-12">
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
        $('.sumoSelect').SumoSelect({search: true, searchText: 'Search Category.',placeholder: 'Search Category',captionFormatAllSelected : 'all Category Selected',captionFormat : '{0} Category selected',selectAll : true});
        $('.sumoSelectTag').SumoSelect({search: true, searchText: 'Search Category.',placeholder: 'Search Tags',captionFormatAllSelected : 'all Tags Selected',captionFormat : '{0} Tags selected',selectAll : true});
    </script>
@stop
@endsection