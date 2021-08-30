@extends('layouts.auth.authMaster')
@section('title','Contact us Setting')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Contact Us Setting</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.setting.contact.update',$contact->id)}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="contactId" value="{{$contact->id}}">
                        @error('contactId')
                            <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                        <div class="row">
                            <img src="{{$contact->image}}" height="250" width="250">
                            <div class="form-group">
                                <label for="image" class="col-form-label">Change Image:</label>
                                <input type="file" name="image">
                            </div>    
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address" value="@if(old('email')){{old('email')}}@else{{$contact->email}}@endif">
                            @error('email')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="facebook" class="col-form-label">Facebook Link:</label>
                            <input type="url" class="form-control @error('facebook') is-invalid @enderror" id="facebook" name="facebook" placeholder="Facebook Link" value="@if(old('facebook')){{old('facebook')}}@else{{$contact->facebook}}@endif">
                            @error('facebook')
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
@endsection