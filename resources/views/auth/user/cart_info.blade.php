@extends('layouts.master')
@section('title','Cart')
@section('content')
    <section class="pt-5 pb-5 mb-5 bg-light">
        <div class="container">
            <div class="row m-0">
                <div class="col-md-8">
                    @php $cartCount = 0;$cartPrice = 0; @endphp
                    @foreach($cart as $key => $usercart)
                        @if($cartProduct = $usercart->product_info)
                            @php $cartCount++; @endphp
                            <div class="card col-12 p-0 mb-3 userCartInfo">
                                <div class="row no-gutters">
                                    <div class="col-md-2 position-relative">
                                        <img src="{{asset($cartProduct->image)}}" class="card-img">
                                        @if($cartProduct->difficulty)
                                            <div class="difficulty_section right-0">
                                                {{$cartProduct->difficulty}}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-body position-relative p-0 ml-4">
                                            <h5 class="card-title">{{words($cartProduct->title,30)}}</h5>
                                            <p class="card-text">{!! words($cartProduct->description,80) !!}</p>
                                            <div class="float-right buynow-btn">
                                                @php
                                                    $display_lessionPrice = $cartProduct->price_usd;
                                                    if($usercart->currency == 'eur') {
                                                        $display_lessionPrice = $cartProduct->price_euro;
                                                    } elseif ($usercart->currency == 'gbp') {
                                                        $display_lessionPrice = $cartProduct->price_gbp;
                                                    } else {
                                                        $display_lessionPrice = $cartProduct->price_usd;
                                                    }
                                                @endphp
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <div><a class="mr-2 text-danger removeFromCart" data-details="{{json_encode($usercart)}}" href="javascript:void(0)">Remove</a></div>
                                        <a class="mr-2" href="javascript:void(0)">{{currencySymbol($usercart->currency)}} {{$display_lessionPrice}}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="col-md-4">
                    <!-- Checkout Part -->
                </div>
            </div>
        </div>
    </section>
    @section('script')
        <script type="text/javascript">
            $(document).on('click','.removeFromCart',function(){
                var clickedObject = $(this),details = JSON.parse(clickedObject.attr('data-details'));
                addOrRemoveUserProductCart(
                    details.userId,details.type_of_product,
                    details.product_info.id,'remove','usd',details.id,clickedObject
                );
            });
        </script>
    @stop
@endsection
