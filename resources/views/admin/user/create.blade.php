@extends('layouts.auth.authMaster')
@section('title','Add User')

@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">ADD NEW User
                        <a class="headerbuttonforAdd" href="{{route('admin.users')}}"><i class="fa fa-step-backward"
                                aria-hidden="true"></i>BACK</a>
                    </h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.user.save')}}" enctype="multipart/form-data" class="row">
                        @csrf
                        <div class="form-group col-lg-6">
                            <label for="image" class="col-form-label">Image:</label>
                            <input type="file" class="form-control" id="image" name="image" value="{{old('image')}}">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="userType" class="col-form-label">User Type:</label>
                            <select class="form-control" name="user_type" id="userType" required>
                                <option value="" hidden="" selected="">Select User Type</option>
                                @foreach($userType as $user_type)
                                <option value="{{$user_type->id}}" {{old('user_type')== $user_type->id?'selected':''}}>
                                    {{$user_type->name}}</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="form-group col-lg-6">
                            <label for="name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Name" value="{{old('name')}}" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="Email" value="{{old('email')}}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="mobile" class="col-form-label">Mobile:</label>
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile"
                                name="mobile" placeholder="Mobile" value="{{old('mobile')}}"
                                onkeypress="return isNumberKey(event)">
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="referral" class="col-form-label">Referral (optional):</label>
                            <input type="text" class="form-control @error('referral') is-invalid @enderror"
                                id="referral" name="referral" placeholder="Referral Code" value="{{old('referral')}}">
                            @error('referral')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea required
                                class="form-control form-control-sm @error('description') is-invalid @enderror"
                                id="description" name="description"
                                placeholder="Description">{{old('description')}}</textarea>
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
<script type="text/javascript" src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.replace('description');
// $('.sumoSelect').SumoSelect({
//     search: true,
//     searchText: 'Search Category.',
//     placeholder: 'Search Category',
//     captionFormatAllSelected: 'all Category Selected',
//     captionFormat: '{0} Category selected',
//     selectAll: true
// });
// $('.sumoSelectTag').SumoSelect({
//     search: true,
//     searchText: 'Search Category.',
//     placeholder: 'Search Tags',
//     captionFormatAllSelected: 'all Tags Selected',
//     captionFormat: '{0} Tags selected',
//     selectAll: true
// });
</script>
<script>
let x = Math.floor((Math.random() * 100) + 1);
document.getElementById("mobile").innerHTML = x;
</script>
@stop
@endsection