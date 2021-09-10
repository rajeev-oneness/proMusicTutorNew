@extends('layouts.auth.authMaster')
@section('title','Add Genre')
@section('content')

<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add New Genre
                        <a class="headerbuttonforAdd" href="{{route('admin.master.genre')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.master.genre.save')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image" class="col-form-label">Genre Name:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="image" name="name" value="{{old('name')}}" placeholder="Genre Name">
                            @error('name')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
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
<script type="text/javascript">
    
</script>
@stop
@endsection