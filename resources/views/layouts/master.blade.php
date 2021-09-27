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
                    <form role="form" action="{{route('razorpay.payment.store')}}" method="POST" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="pk_test_TYooMQauvdEDq54NiTphI7jx" id="payment-form">
                    @csrf
                        <div class="row">
                            <div class="col-12 required">
                                <label for="">Name on the card</label>
                                <input type="text" value="Test" class="form-control form-control-sm" placeholder="Name on the card" size='4'>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 border-0 mt-2 card required">
                                <label for="">Card number</label>
                                <input type="text" value="4242424242424242" class="form-control form-control-sm card-number" placeholder="Card number" size='20'>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 cvc required">
                                <label for="">CVC</label>
                                <input type="text" value="123" class="form-control form-control-sm mr-2 card-cvc" placeholder="CVC">
                            </div>
                            <div class="col-6 expiration required">
                                <label for="">Expiry</label>
                                <div class="d-flex">
                                    <input type="text" value="{{date('m',strtotime('+1 month'))}}" class="form-control form-control-sm mr-2 card-expiry-month" placeholder="MM" size='2'>
                                    <input type="text" value="{{date('Y',strtotime('+1 year'))}}" class="form-control form-control-sm card-expiry-year" placeholder="YYYY" size='4'>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12 error hide">
                                <p class="text-danger" style="font-size: 12px">@error('stripePaymentGateway'){{$message}}@enderror<!-- Please correct the errors and try again.--></p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <a type="button" class="" data-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">Pay ($<span class="amountToPay">0.00</span>)</button>
                            </div>
                        </div>
                        {{-- <p class="small">This payment is processed by Stripe Payment gateway</p> --}}
                    </form>
                </div>
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
            $(document).on('submit', 'form', function() {
                $('button').attr('disabled', 'disabled');
                $('.loading-data').show();
            });
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

        $('.razorpay-payment-button').remove();

        // strpe payment gateway starts
        var stripePrice = 0,redirectURL = '';
        function stripePaymentStart(price,redirectionURL){
            stripePrice = price;redirectURL = redirectionURL;
            $('.amountToPay').text(price);
            $('#stripePaymentModal').modal('show');
            console.log(stripePrice+' => '+redirectURL);
        }
        @error('stripePaymentGateway')
            $('#stripePaymentModal').modal('show');
        @enderror

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
                    $('.loading-data').hide();$('button').attr('disabled', false);
                    $('.error').removeClass('hide').find('.text-danger').text(response.error.message);
                } else {
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.append("<input type='hidden' name='amount' value='" + stripePrice + "'/>");
                    $form.append("<input type='hidden' name='redirectURL' value='" + redirectURL + "'/>");
                    $form.get(0).submit();
                }
            }
        });
        // strpe payment gateway ends

        // wishlist
        function wishlistToggle(id, type) {
            var $this = event.target;
            $.ajax({
                url : "{{route('front.wishlist.toggle')}}",
                method : "POST",
                dataType : "json",
                data : {id : id, type : type, _token : "{{ csrf_token() }}" },
                beforeSend : function() {
                    $($this).html('<i class="fa fa-spinner"></i>').addClass('pe-none');
                },
                success : function(result) {
                    if (result.code == 1) {
                        $($this).html('<i class="fa fa-heart text-light pe-none"></i>').removeClass('pe-none not-wishlisted').addClass('wishlisted');
                    } else {
                        $($this).html('<i class="fa fa-heart text-light pe-none"></i> ').removeClass('pe-none wishlisted').addClass('not-wishlisted');
                    }
                }
            });
        }

        // purchased lesson preview video
        function previewVideo(id, path, name) {
            var targetModalId = '#previewVideoModal';

            $(targetModalId).find('.modal-title').text(name);
            if (!path) {
                $(targetModalId).find('.modal-body').html('<h5 class="text-muted">No preview available !</h5>');
            } else {
                $(targetModalId).find('.modal-body').html('<video class="w-100" autoplay controls><source src="{{asset('')}}'+path+'" type="video/mp4"></video>');
            }
            $(targetModalId).modal('show');
        }
    </script>
    @yield('script')
</body>
</html>