@extends('layouts.auth.authMaster')
@section('title','Subscription')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Subscription List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                	<th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Purchase on</th>
                                    <th>Valid Till</th>
                                    <th>Transaction Id</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($user->purchase_subscription as $key=>$purchase_sub)
                                    <?php $subscriptionPlan = $purchase_sub->subscription;
                                        $transaction = $purchase_sub->transaction;
                                    ?>
                            		<tr>
                                        <td><img src="{{asset($subscriptionPlan->image)}}" height="200" width="200"></td>
                                        <td>{{$subscriptionPlan->title}}</td>
                                        <td>{{$subscriptionPlan->currency->symbol}} {{$transaction->amount / 100}}</td>
                                        <td>{{date('M, d Y, H:i:s',strtotime($purchase_sub->created_at))}}</td>
                                        <td>{{date('M, d Y',strtotime($purchase_sub->valid_till))}}</td>
                                        <td>{{$transaction->transactionId}}</td>
                                    </tr>
                            	@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script type="text/javascript"></script>
@stop
@endsection