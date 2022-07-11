@extends('layouts.master')
@section('title', 'Cart')

@section('content')
    <section class="pt-5 pb-5 bg-light header_padding">
        @php
            $cartCount = 0;
            $cartPrice = 0;
            $cartId = [];
        @endphp
        <div class="container">
            <div class="row m-0">
                @if (count($cart) > 0)
                    <div class="col-md-8">
                        @foreach ($cart as $key => $usercart)
                            @if ($cartProduct = $usercart->product_info)
                                @php
                                    $cartCount++;
                                    $cartId[] = $usercart->id;
                                @endphp
                                <div class="card col-12 p-0 mb-3 userCartInfo">
                                    <div class="row no-gutters">
                                        <div class="col-3 position-relative">
                                            <img src="{{ asset($cartProduct->image) }}" class="card-img">
                                            @if ($cartProduct->difficulty)
                                                <div class="difficulty_section right-0">
                                                    {{ $cartProduct->difficulty }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-7">
                                            <div class="card-body position-relative">
                                                <h5 class="card-title text-gray">{{ words($cartProduct->title, 30) }}</h5>
                                                <p class="card-text">{!! words($cartProduct->description, 80) !!}</p>
                                                <div class="float-right buynow-btn">
                                                    @php
                                                        $price = $cartProduct->price_usd;
                                                        if ($usercart->currency == 'eur') {
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
                                        <div class="col-2 text-center pt-2 pt-md-4">
                                            <a class="mr-2 text-danger removeFromCart w-100 d-block"
                                                data-details="{{ json_encode($usercart) }}"
                                                href="javascript:void(0)">Remove</a>
                                            <a class="mr-2 w-100 d-block pt-2 text-dark" href="javascript:void(0)">
                                                <h6>{{ currencySymbol($usercart->currency) }} {{ $productPrice }}</h6>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if ($cartCount > 0)
                    <div class="col-md-4">
                        <div class="billing-card border-0 shadow-sm mb-2">
                            <h6 class="mb-3">User details</h6>
                            <div class="form-group">
                                <label for="name"><b>Name: </b></label>
                                <input type="text" class="form-control w-75 bg-transparent"
                                    value="{{ Auth::user()->name }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name"><b>Email: </b></label>
                                <input type="text" class="form-control w-75 bg-transparent"
                                    value="{{ Auth::user()->email }}" readonly>
                            </div>
                            @if (Auth::user()->mobile != '')
                                <div class="form-group">
                                    <label for="name"><b>Phone: </b></label>
                                    <input type="text" class="form-control w-75 bg-transparent"
                                        value="{{ Auth::user()->mobile }}" readonly>
                                </div>
                            @endif
                        </div>
                        <div class="billing-card border-0 shadow-sm">
                            @if (count($cart->currency_array) > 1)
                                <p class="small text-danger">Multiple currencies found in your cart. Please select a
                                    specific currency.</p>
                            @else
                                <h6 class="mb-3">Billing summary</h6>
                                <div class="form-group">
                                    <label for=""><b>Total :</b></label>
                                    <input class="form-control" type="text"
                                        value="{{ currencySymbol($usercart->currency) }} {{ number_format($cartPrice, 2) }}"
                                        readonly="">
                                </div>

                                <div class="form-group">
                                    <label for=""><b>Pay</b></label>
                                    <input class="form-control" type="text"
                                        value="{{ currencySymbol($usercart->currency) }} {{ number_format($cartPrice, 2) }}"
                                        readonly="">
                                </div>

                                <div class="form-group justify-content-end">
                                    <a href="javascript:void(0)"
                                        onclick="confirmAlert('{{ route('user.cart.empty') }}')">Empty cart</a>
                                </div>

                                <button class="btn checkoutCartBillPayment">pay now</button>
                            @endif
                            <div class="updateCurrency">
                                <p class="small text-muted">Update currency</p>
                                <form method="post" action="{{ route('user.cart.currency.update') }}" class="w-100">
                                    @csrf
                                    <div class="currencyDiv">
                                        <div class="form-group mb-0">
                                            <select class="form-control form-control-sm" name="currency">
                                                <option value="usd" selected>$ USD</option>
                                                <option value="eur">€ EUR</option>
                                                <option value="gbp">£ GBP</option>
                                            </select>
                                            <button type="submit" name="" class="btn buyfull">Apply</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="w-100">
                        <p class="small text-muted">Update currency</p>
                        <form method="post" action="{{ route('user.cart.currency.update') }}" class="w-100">
                            @csrf
                            <div class="w-100 d-flex">
                                <div class="form-group mb-0 mr-2">
                                    <select class="form-control form-control-sm" name="currency">
                                        <option value="usd" selected>$ USD</option>
                                        <option value="eur">€ EUR</option>
                                        <option value="gbp">£ GBP</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0 mr-2">
                                    <button type="submit" name="" class="btn buyfull">Apply</button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                @else
                    <div class="col-12 text-center">
                        <h4>No item in cart <i class="fas fa-shopping-cart"></i></h4>
                    </div>
                    <div class="col-12 mt-5 text-center"><a href="{{ route('welcome') }}"
                            class="btn btn-sm btn-light border shadow"><i class="fas fa-chevron-left"> </i> Go back to
                            home</a></div>
                @endif
            </div>
        </div>
    </section>
@section('script')
    <script type="text/javascript">
        $(document).on('click', '.removeFromCart', function() {
            var clickedObject = $(this),
                details = JSON.parse(clickedObject.attr('data-details'));
            console.log(details);
            addOrRemoveUserProductCart(
                details.userId, details.type_of_product,
                details.product_info.id, 'remove', 'usd', clickedObject, details.id
            );
        });

        // converToSameArray('usd');
        function converToSameArray(currency) {
            $('.loading-data').show();
            $.ajax({
                url: "{{ route('user.cartinfo.change_to_same_currency') }}",
                type: 'post',
                dataType: 'JSON',
                data: {
                    userId: '{{ $user->id }}',
                    currency: currency,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.error == false) {
                        location.reload();
                    }
                }
            });
        }

        $(document).on('click', '.checkoutCartBillPayment', function() {
            @if (count($cart->currency_array) > 1)
                sweetalertFire('warning', 'Currenty type mismatch');
                return false;
            @else
                @if (count($cart->currency_array) == 1)
                    var cartPrice = "{{ number_format($cartPrice, 2) }}";
                    stripePaymentStart(cartPrice, '{{ route('after.checkout.from_cart', [encrypt($cartId)]) }}',
                        '{{ $cart->currency_array[0] }}');
                @endif
            @endif
        });
    </script>
@stop
@endsection
