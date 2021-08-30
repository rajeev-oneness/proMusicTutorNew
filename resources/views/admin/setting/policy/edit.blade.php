@extends('layouts.auth.authMaster')
@section('title','Policy Edit')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Policy ({{$policy->heading}})
                        <a class="headerbuttonforAdd" href="{{route('admin.setting.policy')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.setting.policy.update',$policy->id)}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="settingId" value="{{$policy->id}}">
                        @error('settingId')
                            <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                        <div class="row">
                            <img src="{{$policy->image}}" height="250" width="250">
                            <div class="form-group">
                                <label for="image" class="col-form-label">Change Image:</label>
                                <input type="file" name="image">
                            </div>    
                        </div>
                        
                        <div class="form-group">
                            <label for="heading" class="col-form-label">Heading:</label>
                            <input type="text" class="form-control @error('heading') is-invalid @enderror" id="heading" name="heading" placeholder="Heading" value="@if(old('heading')){{old('heading')}}@else{{$policy->heading}}@endif">
                            @error('heading')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">@if(old('description')){{old('description')}}@else{{$policy->description}}@endif</textarea>
                            @error('description')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
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