@extends('layouts.master')
@section('title','Login')
@section('content')
    <div class="login-area">
        <div class="full-loginmodal">
            <div class="modal fade modal-fullscreen" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">    
                        <div class="modal-body">
                            <!-- <div class="google-login">
                                <a href="{{route('socialite.login','google')}}">Login with Google</a>
                            </div> -->
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Id" value="{{ old('email') }}" autofocus id="email">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                                <input type="hidden" name="role" value="others">
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" id="pwd">
                                </div>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                                @error('password')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                                @error('socialite')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                                @if (Route::has('password.request'))
                                    <div class="form-group">
                                        <p>Dont have an account? <a href="{{ route('password.request') }}">({{ __('Forgot Your Password?') }})</a></p>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <p>Dont have an account? <a href="{{route('register')}}">(Sign Up)</a></p>
                                </div>
                                <button type="submit" class="btn btn-primary orange-btn">Log In</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
