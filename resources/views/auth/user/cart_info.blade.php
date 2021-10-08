@extends('layouts.master')
@section('title','Cart')
@section('content')
    <section class="pt-5 pb-5 mb-5 bg-light">
        @php $cartCount = 0;$cartPrice = 0;$cartId = [];@endphp
        <div class="container">
            <div class="row m-0">
                @if(count($cart) > 0)
                    <div class="col-md-8">
                        @foreach($cart as $key => $usercart)
                            @if($cartProduct = $usercart->product_info)
                                @php $cartCount++; $cartId[] = $usercart->id; @endphp
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
                                                        $price = $cartProduct->price_usd;
                                                        if($usercart->currency == 'eur') {
                                                            $productPrice = $cartProduct->price_euro;
                                                        } elseif ($usercart->currency == 'gbp') {
                                                            $productPrice = $cartProduct->price_gbp;
                                                        } else {
                                                            $productPrice = $cartProduct->price_usd;
                                                        }
                                                        $cartPrice += $productPrice;
                                                    @endphp
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <div><a class="mr-2 text-danger removeFromCart" data-details="{{json_encode($usercart)}}" href="javascript:void(0)">Remove</a></div>
                                            <a class="mr-2" href="javascript:void(0)">{{currencySymbol($usercart->currency)}} {{$productPrice}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if($cartCount > 0)
                    <div class="col-md-4">
                        <div class="billing-card">
                            <h6 class="mb-2">Billing summary</h6>
                        <div class="form-group">
                            <label for="">Total :</label>
                            <input type="text" value="{{number_format($cartPrice,2)}}" readonly="">
                        </div>
                        <!-- <div class="form-group">
                            <label for="">Discount :</label>
                            <input type="text" value="1449">
                        </div> -->
                        <!-- <div class="form-group">
                            <label for="">Delivery :</label>
                            <input type="text" value="Free">
                        </div> -->
                        <hr>
                        <div class="form-group">
                            <label for=""><b>Pay</b></label>
                            <input type="text" value="{{number_format($cartPrice,2)}}" readonly="">
                        </div>
                        <div class="form-group d-flex justify-content-end">
                           <button class="btn btn-primary checkoutCartBillPayment">CHECKOUT</button>
                        </div>
                        <!-- <div class="coupon">
                            <div class="input-group">
                                <input type="text" placeholder="Apply Coupon Code">
                                <button class="btn-apply">APPLY</button>
                            </div>
                        </div> -->
                        </div>
                    </div>
                @else
                    <div><h4>No item in cart</h4></div>
                @endif
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
            $(document).on('click','.checkoutCartBillPayment',function(){
                @if(count($cart->currency_array) > 1)
                    alert('currenty type must be same for all product');
                    return false;
                @elseif(count($cart->currency_array) == 1)
                    var cartPrice = "{{number_format($cartPrice,2)}}";
                    stripePaymentStart(cartPrice,'{{route("after.checkout.from_cart",[encrypt($cartId)])}}', '{{$cart->currency_array[0]}}');
                @endif
            });
        </script>
    @stop
@endsection
