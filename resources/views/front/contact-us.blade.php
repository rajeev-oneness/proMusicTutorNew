@extends('layouts.master')
@section('title','Contact Us')
@section('content')
<style type="text/css">
    .address p{
        color: #fff;
    }
    .address p a{
       color: #f43600;
    }
    .head{
        font-weight: 800;
        font-size: 18px;
    }
</style>
    <section class="under-contact">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                    <div class="d-sm-flex justify-content-between address">
                        <div class="">
                    <p class="head">UK Correspondence Address:</p>
                    <p>Pro Music Tutor<br/>c/o 11 Belgrave Road<br/>Clifton<br/>Bristol<br/>BS8 2AA</p>
                </div>
                 <div class="">
                    <p class="head">Registered Address:</p>
                    <p>Jem Music International<br/>
Suite 31<br/>
Don House<br/>
30-38 Main Street<br/>
Gibraltar<br/>
GX11 1AA </p>
                </div>

                <div class="">
                    <p class="head">Social Media:</p>
                    <p><a href="https://www.facebook.com/ProMusicTutor">Facebook</a></p>
                    <p><a href="https://twitter.com/promusictutor">Twitter</a></p>
                    <p><br><b>Email Us:</b><br><a href="mailto:info@promusictutor.com">info@promusictutor.com</a></p>
                </div>
                </div>

                  <div class="top-infocon mb-5">
                            <a href="mailto:info@promusictutor.com">EMAIL: <span>{{$contact->email}}</span></a>

                            <a href="{{$contact->facebook}}" target="_blank"> FB: <span>{{$contact->facebook}}</span></a>

                            <p>We typically respond in <span>24 hours</span> or less.</p>

                            @error('success')
                                <div class="alert alert-success valid" role="alert">{{ $message }}</div>
                            @enderror
                        </div>




                    <!-- <img class="full-image" src="{{asset($contact->image)}}" alt=""> -->
                </div>
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                    <div class="con-formarea">
                       <!--  <div class="top-infocon mb-5">
                            <a href="mailto:info@promusictutor.com">EMAIL: <span>{{$contact->email}}</span></a>

                            <a href="{{$contact->facebook}}" target="_blank"> FB: <span>{{$contact->facebook}}</span></a>

                            <p>We typically respond in <span>24 hours</span> or less.</p>

                            @error('success')
                                <div class="alert alert-success valid" role="alert">{{ $message }}</div>
                            @enderror
                        </div> -->
                        <h4 style="color: #fff;margin-bottom: 20px;">Get In Touch</h4>
                        <form method="post" action="{{route('contactus.save')}}">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Your Name" value="{{old('name')}}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone Number" value="{{old('phone')}}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Subject" value="{{old('subject')}}">
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Whats On Your Mind" style="min-height: 100px;max-height: 200px;">{{old('description')}}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary contact-btn">GET CONNECTED WITH US</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
