@extends('layouts.auth.authMaster')
@section('title','Notification')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Notification Report</h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <p>
                        <button class="headerbuttonforAdd d-block mb-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-filter"></i> Filter</button>
                    </p>
                    <div class="collapse show" id="collapseExample">
                        <div class="card card-body px-0 py-2 border-0 shadow-none">
                            <form action="{{route('admin.report.user.notification')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="search">Search</label>
                                        <input type="text" class="form-control form-control-sm mr-2" placeholder="Keyword" name="search" id="search" maxlength="100" value="{{(!empty($req->search)) ? $req->search : ''}}">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="dateFrom">Date from</label>
                                        <input type="date" class="form-control form-control-sm mr-2" placeholder="Date from" name="dateFrom" id="dateFrom" max="{{date('Y-m-d')}}" value="{{(!empty($req->dateFrom)) ? $req->dateFrom : ''}}">
                                    </div>
    
                                    <div class="col-md-3">
                                        <label for="dateTo">Date to</label>
                                        <input type="date" class="form-control form-control-sm mr-2" placeholder="Date to" name="dateTo" id="dateTo" max="{{date('Y-m-d')}}" value="{{(!empty($req->dateTo)) ? $req->dateTo : ''}}">
                                    </div>

                                    <div class="col-md-3 text-right">
                                        <div style="margin-top: 30px"></div>
                                        <button type="submit" class="btn btn-sm btn-primary mr-2"> <i class="fa fa-check"></i> Apply</button>
                                        <a href="{{route('admin.report.user.notification')}}" class="btn btn-sm btn-secondary"> <i class="fa fa-ban"></i> Remove filters</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-left">User Info</th>
                                    <th class="text-left">Notification</th>
                                    <th class="text-left">Date</th>
                                    <th class="text-left">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notification as $noti)
                                    <tr>
                                        <td class="text-left">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h6 class="mt-0">{{$noti->user_details->name}}</h6>
                                                    <p>{{$noti->user_details->email}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-left">{{$noti->message}}</td>
                                        <td class="text-left">{{date('d M, Y',strtotime($noti->created_at))}}</td>
                                        <td class="text-left">{{date('h:i:s A',strtotime($noti->created_at))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="float-right">{{ $notification->appends(request()->query())->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    
@stop
@endsection
