@extends('layouts.auth.authMaster')
@section('title','Edit User')

@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit User
                        <a class="headerbuttonforAdd" href="{{route('admin.users')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.user.update')}}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="user_id" id="user_id" value="{{$editUser['id']}}">
                        <div class="form-group">
                            <img src="{{asset($editUser['image'])}}" alt="user-image" height="100">
                            <br>
                            <label for="image" class="col-form-label">Image:</label>
                            <input type="file" class="form-control" id="image" name="image" value="{{old('image')}}">
                        </div>

                        <div class="form-group">
                            <label for="userType" class="col-form-label">User Type:</label>
                            <select class="form-control" name="user_type" id="userType" required>
                                <option value="" hidden="" selected="">Select User Type</option>
                                @foreach($userType as $user_type)
                                    <option value="{{$user_type->id}}" {{ old('user_type') ? ((old('user_type') == $user_type->id) ? 'selected' : '') : (($editUser['user_type'] == $user_type->id) ? 'selected' : '') }}>{{$user_type->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name" value="{{ old('name') ?? $editUser->name }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') ?? $editUser->email }}" disabled required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mobile" class="col-form-label">Mobile:</label>
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" placeholder="Mobile" value="{{ old('mobile') ?? $editUser->mobile }}" onkeypress="return isNumberKey(event)">
                            @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea required class="form-control form-control-sm @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">{{(old('description') ?? $editUser->description)}}</textarea>
                            @error('description')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Update</button>
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