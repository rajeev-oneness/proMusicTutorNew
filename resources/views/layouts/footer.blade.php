@if(!Session::has('email_subscribe'))
    <section class="pt-5 pb-5 newsletter">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-5">
                    <h6>
                        Try some of our classes!
                        <span>
                            Enter your email and we’ll send you some samples of our favorite classes.
                        </span>
                    </h6>
                </div>
                <div class="col-12 col-md-6">
                    <form method="post" action="{{route('email.subscribe')}}">
                        @csrf
                        <div class="form-group row m-0">
                            <div class="col-8">
                                <input type="email" name="email" class="form-control @error('email'){{('is-invalid')}}@enderror" id="inputPassword2" placeholder="Enter your email address..." value="{{old('email')}}">
                            </div>
                            <button type="submit" class="btn viewmore mb-2">Submit</button>
                        </div>
                        @error('email')<p class="mb-0 small text-danger ml-3" style="font-size: 14px;">{{$message}}</p>@enderror
                        <div class="form-check ml-3">
                            <input class="form-check-input" type="checkbox" checked="" name="agree" value="1" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                              I agree to receive email updates
                            </label>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endif
<footer class="pt-5 pb-3 mt-5 mt-md-0" id="contact">
    <div class="container">
        <div class="row m-0 justify-content-center">
            <div class="col-md-3 col-12 p-0">
                <div class="footer-widget">
                    <img src="{{asset('design/img/logo.png')}}" class="mb-4">
                    <h4 class="widget-title">Your Account</h4>
                    <ul class="footer-menu">
                        <li><a href="{{route('login')}}">Affiliate Sign In</a></li>
                        <li><a href="{{route('home')}}">Login to your Account</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{route('register')}}">Create an account</a></li>
                        @endif
                        @if (Route::has('password.request'))
                            <li><a href="{{route('password.request')}}">Forgotten your password?</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-3 offset-0 offset-md-1 col-12 p-0 pl-md-4">
                <div class="footer-widget">
                    <h4 class="widget-title">Quick Link</h4>
                    <ul class="footer-menu">
                        <li><a href="javascript:void(0)">Affiliates</a></li>
                        <li><a href="{{route('howitworks')}}">How It Works</a></li>
                        <li><a href="javascript:void(0)">Frequently Asked Questions</a></li>
                        <li><a href="{{route('welcome.aboutus')}}">About Us</a></li>
                        <li><a href="{{route('contact.us')}}">Contact Us</a></li>
                        <li><a href="{{route('policy.refund')}}">Refund Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-5 col-12 p-0 pt-5 position-relative">
                <div class="footer-widget">
                    <div class="footer-add">
                        <ul class="footer-card">
                            @for($loop = 1; $loop <= 8; $loop++)
                                <li><a href="javascript:void(0)"><img src="{{asset('design/img/card'.$loop.'.png')}}"></a></li>
                            @endfor
                        </ul>
                    </div>
                </div>
                <div class="sub-footer">
                    <ul>
                        <li>
                            <a href="{{route('terms&condition')}}">Terms of Use</a>
                        </li>
                        <li>|</li>
                        <li>
                            <a href="{{route('privacy.policy')}}">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bottom-footer mt-5">
        <div class="row m-0">
            <div class="col-12 col-md-6 pt-0 pt-md-2">
                <p>© Jem Music International. Company No. 106351</p>
            </div>
            <div class="col-12 col-md-2 ml-auto social_icon d-flex">
                <a href="{{$contact->facebook}}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="{{$contact->linkedin}}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                <a href="{{$contact->youtube}}" target="_blank"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
</footer>