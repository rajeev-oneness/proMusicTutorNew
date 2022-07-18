@extends('layouts.master')
@section('title','Payment failure')

@section('content')
    <section style="padding-top: 75px;padding-bottom: 100px;margin-top: 85px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4 class="display-4 text-danger mb-3">Payment Failure</h4>

                    @if (request()->input('reason'))
                        @if (request()->input('reason') == "userCancelled")

                            <h5>User cancelled from their end</h5>

                        @elseif(request()->input('reason') == "failedToCapture")

                            <h5>Payment failed to capture</h5>

                        @elseif(request()->input('reason') == "internalFailure")

                            <h5>Payment failed due to internal failure</h5>

                        @endif
                    @else
                        <h5>Something happened</h5>
                    @endif

                    <a href="{{ route('user.cart.info') }}" class="btn btn-dark mt-3">Go back to cart</a>
                </div>
            </div>
        </div>
    </section>
@endsection
