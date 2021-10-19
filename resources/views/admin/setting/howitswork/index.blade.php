@extends('layouts.auth.authMaster')
@section('title','How It Works Setting')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">How it Work Setting</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                	<th>Image</th>
                                    <th>Heading</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($howitswork as $key=>$how)
                            		<tr>
                            			<td><img src="{{asset($how->image)}}" height="auto" width="100"></td>
                            			<td>{{$how->heading}}</td>
                            			<td>{!! $how->description !!}</td>
                            			<td><a href="{{route('admin.setting.howitWorks.edit',$how->id)}}"><i class="fas fa-edit"></i></a></td>
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
@endsection