@extends('layouts.master')
@section('title', 'Administrator')

@section('content')
<div class="container">
	<div class="row mt-5">
		<div class="col-md-3"></div>
		<div class="col-md-6 text-center"><br><br>
			<h2>Administrator Login</h2><br>
			<form action="{{ route('login') }}" method="post">
			    @csrf
			    <div class="form-group">
			        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Id" value="{{ old('email') }}" autofocus id="email">
			        @error('email')
			            <span class="invalid-feedback" role="alert">{{ $message }}</span>
			        @enderror
			    </div>
			    <input type="hidden" name="role" value="administrator">
			    <div class="form-group">
			        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" id="pwd">
			        @error('password')
			            <span class="invalid-feedback" role="alert">{{ $message }}</span>
			        @enderror
			        @error('socialite')
			            <span class="invalid-feedback" role="alert">{{ $message }}</span>
			        @enderror
			    </div>
			    @if (Route::has('password.request'))
			        <div class="form-group">
			            <p>Dont have an account? <a href="{{ route('password.request') }}">({{ __('Forgot Your Password?') }})</a></p>
			        </div>
			    @endif
			    <button type="submit" class="btn btn-primary orange-btn">Log In</button>
			</form>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>
@endsection