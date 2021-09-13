@extends('layouts.auth.authMaster')
@section('title','Profile')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Your Profile</h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('user.profile.save')}}" enctype="multipart/form-data">
                        @csrf
                        <img src="{{asset($user->image)}}" height="200" width="200">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="image" class="col-form-label">Image:</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="name" class="col-form-label">Name:</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{(old('name') ? old('name') : $user->name)}}" autofocus="">
                                @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email" class="col-form-label">Email:</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email eg: abc@xyz.com" value="{{(old('email') ? old('email') : $user->email)}}">
                                @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobile" class="col-form-label">Mobile:</label>
                                <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" value="{{(old('mobile') ? old('mobile') : $user->mobile)}}" onkeypress="return isNumberKey(event);" maxlength="20">
                                @error('mobile')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="referral" class="col-form-label">Referral Code:</label>
                                <input type="text" name="referral" class="form-control @error('referral') is-invalid @enderror" value="{{$user->referral_code}}" readonly disabled>
                                @error('referral')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="gender" class="col-form-label">Gender:</label>
                                <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                    <option value="" selected="" hidden="">Select Gender</option>
                                    <option value="Male" @if($user->gender=='Male'){{('selected')}}@endif>Male</option>
                                    <option value="Female" @if($user->gender=='Female'){{('selected')}}@endif>Female</option>
                                    <option value="Not specified" @if($user->gender=='Not specified'){{('selected')}}@endif>Not specified</option>
                                </select>
                                @error('gender')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="dob" class="col-form-label">Date of Birth:</label>
                                <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" value="{{(old('dob') ? old('dob') : $user->dob)}}" onkeypress="return false;">
                                @error('dob')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="marital" class="col-form-label">Marital:</label>
                                <select name="marital" class="form-control @error('marital') is-invalid @enderror" onchange="changeMaritalStatus(this)">
                                    <option value="" selected="" hidden="">Select Marital</option>
                                    <option value="Single" @if($user->marital=='Single'){{('selected')}}@endif>Single</option>
                                    <option value="Married" @if($user->marital=='Married'){{('selected')}}@endif>Married</option>
                                    <!-- <option value="Divorced" @if($user->marital=='Divorced'){{('selected')}}@endif>Divorced</option> -->
                                </select>
                                @error('marital')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                            <div class="form-group col-md-4 anniversaryDiv" @if($user->marital == 'Single' || $user->marital =='') style="display:none;" @endif>
                                <label for="aniversary" class="col-form-label">Anniversary:</label>
                                <input type="date" id="anniversaryInput" name="aniversary" class="form-control @error('aniversary') is-invalid @enderror" value="{{(old('aniversary') ? old('aniversary') : $user->aniversary)}}" onkeypress="return false;">
                                @error('aniversary')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>

                        @if($user->user_type == 2)
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="carrier_started" class="col-form-label">Carrer Started:</label>
                                    <input type="date" name="carrier_started" class="form-control @error('carrier_started') is-invalid @enderror" value="{{(old('carrier_started') ? old('carrier_started') : $user->carrier_started)}}" onkeypress="return false;">
                                    @error('carrier_started')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="specialist" class="col-form-label">Specialist:</label>
                                    <select id="specialist" name="specialist" class="form-control @error('specialist') is-invalid @enderror">
                                        <option value="" selected="" hidden="">Select Specialist</option>
                                        @foreach($instrument as $key => $ins)
                                            <option value="{{$ins->name}}" @if((old('specialist') ?? $user->specialist) == $ins->name){{('selected')}}@endif>{{$ins->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('specialist')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="about" class="col-form-label">About:</label>
                                <textarea class="form-control @error('about') is-invalid @enderror" id="about" name="about" placeholder="About">{{(old('about') ?? $user->about)}}</textarea>
                                @error('about')<span class="text-danger" role="alert">{{$message}}</span>@enderror
                            </div>
                        @endif

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Change Password</h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('user.changepassword.save')}}">
                        @csrf
                        
                        <div class="form-group col-md-6">
                            <label for="old_password" class="col-form-label">Old Password</label>
                            <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" autofocus="" placeholder="Old password" value="{{old('old_password')}}">
                            @error('old_password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password" class="col-form-label">New Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="New password">
                            @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password_confirmation" class="col-form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                        </div>

                        <div class="form-group col-md-6">
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
        CKEDITOR.replace('about');

        function changeMaritalStatus(thisOb){
            if(thisOb.value == 'Married'){
                $('.anniversaryDiv').show();
                $('#anniversaryInput').attr('required',true);
            }else{
                $('.anniversaryDiv').hide();
                $('#anniversaryInput').attr('required',false);
            }
        } 
    </script>
@stop
@endsection
