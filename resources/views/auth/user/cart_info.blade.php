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
                                <p class="small text-danger">Multiple currencies found in your cart. Please select a specific currency.</p>
                            @else
                                <h6 class="mb-3">Billing summary</h6>
                                <div class="form-group">
                                    <label for=""><b>Total :</b></label>
                                    <input class="form-control" type="text" value="{{ currencySymbol($usercart->currency) }} {{ number_format($cartPrice, 2) }}" readonly="">
                                </div>

                                <div class="form-group">
                                    <label for=""><b>Pay</b></label>
                                    <input class="form-control" type="text" value="{{ currencySymbol($usercart->currency) }} {{ number_format($cartPrice, 2) }}" readonly="">
                                </div>

                                <div class="form-group justify-content-end">
                                    <a href="javascript:void(0)" onclick="confirmAlert('{{ route('user.cart.empty') }}')">Empty cart</a>
                                </div>

                                {{-- STRIPE --}}
                                <button class="btn checkoutCartBillPayment">Pay now (Stripe)</button>
                                {{-- PAYPAL --}}
                                <div id="paypal-button-container" class="mt-3"></div>
                                {{-- <div id="btn-paypal-checkout" class="mt-3"></div> --}}
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
                    <div class="col-12 mt-5 text-center"><a href="{{ route('welcome') }}" class="btn btn-sm btn-light border shadow"><i class="fas fa-chevron-left"> </i> Go back to home</a></div>
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

    {{-- paypal script --}}
    <script>
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color:  'gold',
                shape:  'rect',
                label:  'pay',
                Tagline: false
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    application_context: {
                    brand_name : 'Laravel Book Store Demo Paypal App',
                    user_action : 'PAY_NOW',
                    },
                    purchase_units: [{
                        amount: {
                            currency_code: 'USD',
                            value: '{{$cartPrice}}'
                        }
                    }],
                });
            },
            onApprove: function(data, actions) {
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                return actions.order.capture().then(function(details) {
                    if(details.status == 'COMPLETED'){
                        return fetch('/api/paypal-capture-payment', {
                            method: 'post',
                            headers: {
                                'content-type': 'application/json',
                                "Accept": "application/json, text-plain, */*",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": token
                            },
                            body: JSON.stringify({
                                orderId     : data.orderID,
                                id : details.id,
                                status: details.status,
                                payerEmail: details.payer.email_address,
                            })
                        })
                        .then(status)
                        .then(function(response){
                            window.location.href = '/payment-success';
                        })
                        .catch(function(error) {
                            window.location.href = '/payment-failure?reason=internalFailure';
                        });
                    }else{
                        window.location.href = '/payment-failure?reason=failedToCapture';
                    }
                });
            },
            onCancel: function (data) {
                window.location.href = '/payment-failure?reason=userCancelled';
            }
        }).render('#paypal-button-container');

        // This function displays Smart Payment Buttons on your web page.
        function status(res) {
            if (!res.ok) {
                throw new Error(res.statusText);
            }
            return res;
        }


        /* paypal.Buttons({
            style: {
                layout: 'vertical',
                color:  'gold',
                shape:  'rect',
                label:  'pay',
                Tagline: false
            },
            createOrder: function(data, actions) {
                // Set up the transaction
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            currency_code: 'USD',
                            value: {{$cartPrice}}
                        }
                    }]
                });
            }
        }).render('#paypal-button-container'); */
    </script>

    <script>
        /* window.addEventListener("load", function () {
            // Render the PayPal button
            paypal.Button.render({
                env: 'sandbox', // sandbox | production
                style: {
                    label: 'pay',
                    shape: 'rect',
                    color: 'gold',
                    layout: 'vertical'
                },
                client: {
                    sandbox: 'Adqys1kmmR1q-yFM-f4GLdU2uirN1uVPcGBiksWNrqfI1DDTfza1uJk8pyvOQro00YzQqaYTFPcB9rCi',
                    // production: ''
                },
                funding: {
                    allowed: [
                        paypal.FUNDING.CARD,
                        paypal.FUNDING.ELV
                    ]
                },
                payment: function(data, actions) {
                    return actions.payment.create({
                        payment: {
                            transactions: [{
                                amount: {
                                    total: {{$cartPrice}},
                                    currency: 'USD'
                                },
                            }]
                        }
                    });
                },
                onAuthorize: function(data, actions) {
                    return actions.payment.execute().then(function() {
                        // you can use all the values received from PayPal as you want
                        console.log({
                            "intent": data.intent,
                            "orderID": data.orderID,
                            "payerID": data.payerID,
                            "paymentID": data.paymentID,
                            "paymentToken": data.paymentToken
                        });

                        // AJAX call here
                        paymentMade(data.orderID, data.payerID, data.paymentID, data.paymentToken);
                    });
                },
                onCancel: function (data, actions) {
                    console.log(data);
                }

            }, '#btn-paypal-checkout');
        });

        // server side save request
        function paymentMade(orderID, payerID, paymentID, paymentToken) {
            var ajax = new XMLHttpRequest();
            ajax.open("POST", "{{route('paypal.payment.store')}}", true);
            ajax.onreadystatechange = function () {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        console.log(response);
                        if (response.status == 'error') {
                            sweetalertFire('warning', response.message);
                        } else {
                            sweetalertFire('success', response.message);
                        }
                    }
                    if (this.status == 500) {
                        sweetalertFire('warning', this.responseText.message);
                        // console.log(this.responseText);
                    }
                }
            };
            var formData = new FormData();
            formData.append("_token", '{{csrf_token()}}');
            formData.append("orderID", orderID);
            formData.append("payerID", payerID);
            formData.append("paymentID", paymentID);
            formData.append("paymentToken", paymentToken);
            ajax.send(formData);
        } */
    </script>
@stop
@endsection
