<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{config('app.name', 'Pro Music Tutor')}} - Signup</title>
    <link rel="stylesheet" type="text/css" href="{{asset('design/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('design/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('design/css/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('design/css/font-awesome.min.css')}}">
</head>
<body>
    <div class="signup pt-5 pb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                    <div class="padd-area">
                        <div class="left-signin mb-5">
                            <img src="{{asset('design/img/logopro.png')}}">
                        </div>
                        <div class="signupacc-text">
                            <h3>Sign Up Your Account</h3>
                            <p>To keep connected with us please Register with your personal information by email address and password</p>
                        </div>
                    </div>

                    <div>
                        <img src="{{asset('design/img/signup-image.png')}}">
                    </div>
                </div>

                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                    <div class="signup-area">
                        <div class="under-formarea">
                            <!-- <div class="google-login">
                                <a href="{{route('socialite.login','google')}}">Login with Google</a>
                            </div>
                            <div class="text-center">
                                <span class="orpart">or</span>
                            </div> -->
                            <form method="post" action="{{route('register')}}" class="signup-form">
                                @csrf
                                <input type="hidden" name="user_type" value="3" readonly>
                                <div class="form-group">
                                    <label for="inputAddress"> <img src="{{asset('design/img/mail-icon.png')}}"> Name </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Full name" value="{{old('name')}}" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="inputAddress"> <img src="{{asset('design/img/mail-icon.png')}}"> EMAIL ADDRESS </label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email Address" value="{{old('email')}}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="inputAddress"> <img src="{{asset('design/img/password.png')}}"> PASSWORD 
                                        @if (Route::has('password.request'))
                                            {{-- <span><a class="btn btn-link" href="{{ route('password.request') }}">
                                                (Forgot)
                                            </a></span> --}}
                                        @endif
                                    </label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="inputAddress"> <img src="{{asset('design/img/password.png')}}"> CONFIRM PASSWORD </label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                    <a class="confirmpw" href="javascript:void(0)"><img src="{{asset('design/img/eye.png')}}"></a>
                                </div>

                                <div class="form-group">
                                    <label for="inputAddress"> <img src="{{asset('design/img/password.png')}}"> Referral Code </label>
                                    <input type="text" class="form-control" name="referral_code" placeholder="Referral Code (optional)" value="{{old('referral_code')}}">
                                    @error('referral_code')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="already-have">
                                    <p>Already have an account? <span><a href="{{route('login')}}">(Sign In)</a></span></p>
                                </div>

                                <button type="submit" class="btn btn-primary btn-signup">Sign Up</button>
                            </form>

                            <p class="endsign">Protected by reCAPTCHA. Google <a href="{{route('privacy.policy')}}">Privacy Policy</a> & <a href="{{route('terms&condition')}}">Terms of Service</a> apply.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('design/js/jquery-3.6.0.min.js')}}"></script>
</body>
</html>