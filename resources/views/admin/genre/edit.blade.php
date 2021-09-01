@extends('layouts.auth.authMaster')
@section('title','Edit Genre')
@section('content')

<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Genre
                        <a class="headerbuttonforAdd" href="{{route('admin.guitar.category')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.guitar.category.update',$category->id)}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="categoryId" value="{{$category->id}}">
                        @error('categoryId')
                            <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                        <img src="{{$category->image}}" height="300" width="300">
                        <div class="form-group">
                            <label for="image" class="col-form-label">Update Image:</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image" class="col-form-label">Instrument Name:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="image" name="name" value="{{$category->name}}" placeholder="Instrument Name">
                            @error('name')
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
    <script type="text/javascript">
        
    </script>
@stop
@endsection