@extends('layouts.auth.authMaster')
@section('title', 'Sales Report')

@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card w-100">
                    <div class="card-header w-100 d-flex justify-content-between">
                        <h5 class="mb-0">Edit Order Details</h5>
                        <a href="{{ route('admin.report.transaction') }}" class="btn btn-dark btn-sm"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
