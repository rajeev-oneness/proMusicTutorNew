@extends('layouts.auth.authMaster')
@section('title','About Us Setting')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">About Us Setting</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.setting.aboutus.update',$aboutUs->id)}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="settingId" value="{{$aboutUs->id}}">
                        @error('settingId')
                            <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                        <div class="row">
                            <div class="col-lg-6">
                            <div class="form-group image-upload-wrapper">
                                <img src="{{asset($aboutUs->image)}}" width="250">
                                <input type="file" name="image" class="form-control">
                                <button><i class="fas fa-pencil-alt"></i></button>
                            </div>   
                            <div class="form-group">
                                    <label for="description" class="col-form-label">Description:</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">@if(old('description')){{old('description')}}@else{{$aboutUs->description}}@endif</textarea>
                                    @error('description')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div> 
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="heading" class="col-form-label">Heading:</label>
                                    <input type="text" class="form-control @error('heading') is-invalid @enderror" id="heading" name="heading" placeholder="Email Address" value="@if(old('heading')){{old('heading')}}@else{{$aboutUs->heading}}@endif">
                                    @error('heading')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                

                                <div class="form-group">
                                    <label for="description2" class="col-form-label">Description 2:</label>
                                    <textarea class="form-control @error('description2') is-invalid @enderror" id="description2" name="description2" placeholder="Description 2">@if(old('description2')){{old('description2')}}@else{{$aboutUs->description2}}@endif</textarea>
                                    @error('description2')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
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
        CKEDITOR.replace('description2');  
    </script>
@stop
@endsection