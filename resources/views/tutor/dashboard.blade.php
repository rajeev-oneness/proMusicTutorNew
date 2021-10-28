@extends('layouts.auth.authMaster')
@section('title','Dashboard')

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tutor Dashboard</h5>
                </div>
                <div class="card-body">
                    <!-- <p>Welcome to the Dashboard</p> -->
                    <div class="dashboard-body-content-upper p-0">
                        <h5 class="mb-0">Instrument Product Series</h5><br>
                        <div class="row m-0">
                            @foreach($data->instrument as $key => $instrument)
                                <div class="col-md-3 dash-card-col">
                                    <a href="{{route('tutor.product.series.list',[$instrument->id,'instrument='.$instrument->name])}}">
                                        <div class="card card-body mb-0" style="background-image: url({{asset($instrument->image)}})">
                                            <h5 class="mb-2">{{$instrument->name}} ({{count($instrument->product)}})</h5>
                                            <p class="small mb-0">
                                                View series' list
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection