@extends('layouts.master')
@section('title','Subscription')
@section('content')
<!--     <section class="banner series_details subsscription">
        <div class="container">
            <div class="row m-0">
                <div class="col-12 col-md-5">
                    <h1>Welcome to <span class="d-block">Pro Music Tutor</span></h1>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    <form>
                        <div class="form-group row m-0 mb-4">
                            <label class="col-md-3 col-6 col-form-label">Currencies:</label>
                            <div class="col-md-4 col-6">
                                <select class="form-control">
                                    <option>&pound; - GBP</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-group row m-0">
                            <input type="text" class="form-control keyword" placeholder="Enter Keyword...">
                            <div class="input-group-append">
                                <button class="btn viewmore" type="button">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section> -->

    @if(count($data->subscription) > 0)
        <section class="pt-5 pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center title-inner">
                        <h1 class="mb-5">Subscription Plans</h1>
                    </div>
                </div>
                <div class="row">
                    @foreach($data->subscription as $key => $subscription)
                        <div class="col-12 col-sm-6 col-md-4 mb-3">
                            <div class="card border-0 bg-light-blue subscribe-card">
                                <img src="{{asset($subscription->image)}}" class="card-img-top">
                                <div class="card-body text-center">
                                    <p>{{$subscription->title}}</p>
                                    <h6>£ {{$subscription->price}} <span>/month</span></h6>
                                    <ul class="child-subs">
                                        @foreach($subscription->features as $feature)
                                            <li>{{$feature->title}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @if($subscription->userSubscribed)
                                    <div class="card-footer border-0 p-0">
                                        <a href="javascript:void(0)" class="btn buyfull d-block bg-purchased">Already Subscribed</a>
                                    </div>
                                @else
                                    <form id="checkoutForm{{$subscription->id}}" action="{{route('razorpay.payment.store')}}" method="POST" >
                                        @csrf
                                        <input type="hidden" name="redirectURL" value="{{route('after.purchase.subscribe',$subscription->id)}}">
                                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                                data-key="{{ env('RAZORPAY_KEY') }}"
                                                data-amount="{{($subscription->price) * 100}}"
                                                /****data-buttontext="Pay {{$subscription->price}} INR"****/
                                                data-name="Pro Music Tutor"
                                                data-description="All downloads available in FULL HD or stream"
                                                data-image="{{asset('defaultImages/logo.jpeg')}}"
                                                /*data-prefill.name=""
                                                data-prefill.email=""*/
                                                data-theme.color="#ff7529">
                                        </script>
                                        @guest
                                            <div class="card-footer border-0 p-0">
                                                <a href="javascript:void(0)" class="btn buyfull d-block bg-orange" onclick="alert('please login to continue')">SUBSCRIBE NOW</a>
                                            </div>
                                        @else
                                            <div class="card-footer border-0 p-0">
                                                <a href="javascript:void(0)" class="btn buyfull d-block bg-orange" onclick="$('#checkoutForm{{$subscription->id}}').submit()">SUBSCRIBE NOW</a>
                                            </div>
                                        @endguest
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@section('script')
<script type="text/javascript">
    $('.razorpay-payment-button').remove();
</script>
@endsection
