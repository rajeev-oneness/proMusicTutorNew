@extends('layouts.auth.authMaster')
@section('title','Blogs')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Blog Comment for '{{$data->title}}'
                        <a class="headerbuttonforAdd" href="{{route('admin.blog.data.list')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Comment id</th>
                                	<th>User Info</th>
                                	<th>Comment</th>
                                    <th>Date/Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->comments as $key => $value)
                                    <tr>
                                        <td>#{{$value->id}}</td>
                                        <td>
                                            <div class="media">
                                                <img class="mr-3 rounded-circle" src="{{asset($value->user_data->image)}}" alt="user-image" style="height: 50px;width: 50px;">
                                                <div class="media-body">
                                                    <p class="mb-0">{{$value->user_data->name}}</p>
                                                    <p class="text-muted mb-0">{{$value->user_data->email}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$value->comment}}</td>
                                        <td>{{date('M d, Y h:i A',strtotime($value->created_at))}}</td>
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

@stop
@endsection