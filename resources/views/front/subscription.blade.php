@extends('layouts.master')
@section('title','Subscription')
@section('content')

    @if(count($data->subscription) > 0)
        <section class="pt-5 pb-5 subs_sec">
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
                                    <h6>$ {{$subscription->price}} <span>/month</span></h6>
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
                                    @guest
                                        <div class="card-footer border-0 p-0">
                                            <a href="javascript:void(0)" class="btn buyfull d-block bg-orange" onclick="alert('please login to continue')">SUBSCRIBE NOW</a>
                                        </div>
                                    @else
                                        <div class="card-footer border-0 p-0">
                                            <a href="javascript:void(0)" class="btn buyfull d-block bg-orange" onclick="stripePaymentStart('{{$subscription->price}}','{{route('after.purchase.subscribe',$subscription->id)}}');">SUBSCRIBE NOW</a>
                                        </div>
                                    @endguest
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
<script type="text/javascript"></script>
@endsection
