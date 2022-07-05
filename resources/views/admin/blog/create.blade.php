@extends('layouts.auth.authMaster')
@section('title','Create Blogs')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">ADD Blog
                        <a class="headerbuttonforAdd" href="{{route('admin.blog.data.list')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.blog.data.save')}}" enctype="multipart/form-data" class="row">
                        @csrf
                        <div class="form-group col-lg-6">
                            <label for="image" class="col-form-label">Image:</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="title" class="col-form-label">Title:</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{old('title')}}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="category" class="col-form-label">Category:</label>
                            <select class="sumoSelect form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                                @foreach($data->category as $catIndex => $catValue)
                                    <option value="{{$catValue->id}}" @if(old('category') == $catValue->id){{('selected')}}@endif>{{$catValue->title}}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        @php $selectedTags = (old('tags') ?? []); @endphp
                        <div class="form-group col-lg-6">
                            <label for="tags" class="col-form-label">Tags:</label>
                            <select class="sumoSelectTag form-control @error('tags') is-invalid @enderror" id="tags" name="tags[]" multiple required>
                                @foreach($data->tags as $tagIndex => $tagValue)
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
                            <textarea required class="form-control form-control-sm @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">{{old('description')}}</textarea>
                            @error('description')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                        </div>

                        <div class="form-group col-lg-12">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script type="text/javascript" src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
    {{-- <script src="https://cdn.ckeditor.com/4.19.0/standard-all/ckeditor.js"></script> --}}
    <script type="text/javascript">
        CKEDITOR.replace('description');
        $('.sumoSelect').SumoSelect({search: true, searchText: 'Search Category.',placeholder: 'Search Category',captionFormatAllSelected : 'all Category Selected',captionFormat : '{0} Category selected',selectAll : true});
        $('.sumoSelectTag').SumoSelect({search: true, searchText: 'Search Category.',placeholder: 'Search Tags',captionFormatAllSelected : 'all Tags Selected',captionFormat : '{0} Tags selected',selectAll : true});
    </script>
@stop
@endsection