@extends('layouts.auth.authMaster')
@section('title','Lession')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Your Guitar Series Lession</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                	<th>Image</th>
                                    <th>Name</th>
                                    <th>Series</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Purchase On</th>
                                    <th>Transaction Id</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($user->product_purchase_lession as $key => $purchase_lession)
                                <?php   
                                    $lession = $purchase_lession->product_series_lession;
                                    $transaction = $purchase_lession->transaction;
                                    $productSeries = $purchase_lession->product_series;
                                ?>
                                <tr>
                                    <td><img src="{{asset($lession->image)}}" height="200" width="200"></td>
                                    <td>{{$lession->title}}</td>
                                    <td>{{$productSeries->title}}</td>
                                    <td>£{{$lession->price}}</td>
                                    <td>{!! words($lession->description,200) !!}</td>
                                    <td>{{$purchase_lession->created_at}}</td>
                                    <td>{{$transaction->transactionId}}</td>
                                    <td><a href="{{route('product.series.details',$lession->productSeriesId)}}">View</a></td>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example4').DataTable();
        });
    </script>
@stop
@endsection