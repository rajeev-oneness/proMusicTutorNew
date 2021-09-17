<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{config('app.name', 'Pro Music Tutor')}} - @yield('title')</title>
    <link rel="icon" href="{{asset('design/img/logo.png')}}" type="image/gif" sizes="any">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<link rel="stylesheet" type="text/css" href="{{asset('design/css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('design/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('design/css/owl.theme.default.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('design/css/style.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('design/css/responsive.css')}}">
	@yield('css')
</head>
<body>
	<!-- loader -->
    <div class="loading-data" style="display:block; color: #fff;">Loading&#8230;</div>
    <!-- Header Content -->
    @include('layouts.header')
    
    @yield('content')
    <!-- stripe Payement -->
    <div class="modal fade align-modal" id="stripePaymentModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="stripePaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stripePaymentModalLabel">Stripe payment gateway</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="required-validation" data-cc-on-file="false" data-stripe-publishable-key="pk_test_TYooMQauvdEDq54NiTphI7jx" id="payment-form">
                    @csrf
                        <div class="row">
                            <div class="col-12 required">
                                <label for="">Name on the card</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Name on the card">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 card border-0 mt-2 required">
                                <label for="">Card number</label>
                                <input type="text" class="form-control form-control-sm card-number" placeholder="Card number">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 cvc required">
                                <label for="">CVC</label>
                                <input type="text" class="form-control form-control-sm mr-2 card-cvc" placeholder="CVC">
                            </div>
                            <div class="col-6 expiration required">
                                <label for="">Expiry</label>
                                <div class="d-flex">
                                    <input type="text" class="form-control form-control-sm mr-2 card-expiry-month" placeholder="MM">
                                    <input type="text" class="form-control form-control-sm card-expiry-year" placeholder="YYYY">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12 error hide">
                                <p class="text-danger" style="font-size: 12px">Please correct the errors and try again.</p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <a type="button" class="" data-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">Pay (<span class="amount">$1200.99</span>)</button>
                            </div>
                        </div>
                        {{-- <p class="small">THis payment is processed by Stripe Payment gateway</p> --}}
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    
                </div> --}}
            </div>
        </div>
    </div>
    <!-- stripe Payment End -->

    @include('layouts.footer')

    <script type="text/javascript" src="{{asset('design/js/jquery-3.6.0.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('design/js/popper.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('design/js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('design/js/owl.carousel.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('design/js/aos.js')}}"></script>
	<script type="text/javascript" src="{{asset('design/js/custom.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.loading-data').hide();
        });
        
        @if(Session::has('Success'))
            swal('Success','{{Session::get('Success')}}');
        @elseif(Session::has('Errors'))
            swal('Error','{{Session::get('Errors')}}');
        @endif

        function isNumberKey(evt){
            if(evt.charCode >= 48 && evt.charCode <= 57 || evt.charCode <= 43){  
                return true;  
            }  
            return false;  
        }

        $('#stripePaymentModal').modal('show');

        // strpe payment gateway starts
        $(function () {
            var $form = $(".require-validation");
            $('form.require-validation').bind('submit', function (e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function (i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }
            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    {{--
                        $form.append("<input type='hidden' name='amount' value='{{$finalPayment}}'/>");
                        $form.append("<input type='hidden' name='percentage' value='{{$item->percentage}}'/>");
                    --}} 
                    $form.get(0).submit();
                }
            }
        });
        // strpe payment gateway ends
    </script>
    @yield('script')
</body>
</html>