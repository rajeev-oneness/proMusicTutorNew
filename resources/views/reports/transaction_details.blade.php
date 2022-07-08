@extends('layouts.auth.authMaster')
@section('title', 'Sales Report')

@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card w-100">
                    <div class="card-header w-100 d-flex justify-content-between">
                        <h5 class="mb-0">Order Details</h5>
                        <a href="{{ route('admin.report.transaction') }}" class="btn btn-dark btn-sm"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example5" class="table table-sm table-hover table-striped table-bordered"
                                    style="width:100%">

                                    <thead style="background: rgb(147, 164, 164);">
                                        <tr>
                                            <td colspan="2">Order ID: {{ $transaction_data->order_id }}</td>
                                        </tr>
                                    </thead>

                                    @php
                                        if ($transaction_data->currency == 'usd') {
                                            $curr = '$ ';
                                        
                                            if ($data[0]->type_of_product == 'series') {
                                                $b_price = number_format($productSeries_data->price_usd);
                                            } elseif ($data[0]->type_of_product == 'offer') {
                                                $b_price = number_format($offerSeries_data->price_usd);
                                            } else {
                                                $b_price = number_format($data[0]->price_usd);
                                            }
                                        } elseif ($transaction_data->currency == 'gbp') {
                                            $curr = '£ ';
                                        
                                            if ($data[0]->type_of_product == 'series') {
                                                $b_price = number_format($productSeries_data->price_gbp);
                                            } elseif ($data[0]->type_of_product == 'offer') {
                                                $b_price = number_format($offerSeries_data->price_gbp);
                                            } else {
                                                $b_price = number_format($data[0]->price_gbp);
                                            }
                                        } else {
                                            $curr = '€ ';
                                        
                                            if ($data[0]->type_of_product == 'series') {
                                                $b_price = number_format($productSeries_data->price_euro);
                                            } elseif ($data[0]->type_of_product == 'offer') {
                                                $b_price = number_format($offerSeries_data->price_euro);
                                            } else {
                                                $b_price = number_format($data[0]->price_euro);
                                            }
                                        }
                                    @endphp

                                    <tbody>
                                        <tr>
                                            <td>User Name: </td>
                                            <td>{{ $user_data->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>User Email: </td>
                                            <td>{{ $user_data->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>User Description: </td>
                                            <td>{{ $user_data->description }}</td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: top !important;">Bought :</td>
                                            <td>
                                                @foreach ($data as $item)
                                                    {{ $item->title . ' - ' . $curr . ($transaction_data->currency == 'usd' ? $item->price_usd : ($transaction_data->currency == 'eur' ? $item->price_euro : $item->price_gbp)) }}
                                                    <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Actual Price: </td>
                                            <td>{{ $curr . $b_price }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount Price: </td>
                                            <td>{{ $curr . '00' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Paid Price: </td>
                                            <td>{{ $curr . number_format($transaction_data->amount / 100) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Purchased On: </td>
                                            <td>{{ date('d, F Y', strtotime($transaction_data->created_at)) }}</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
