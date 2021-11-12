@extends('layouts.auth.authMaster')
@section('title','Point')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <?php $pointTransaction = $user->user_points; ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">User Points of ({{$user->name}})
                        @if(Auth::user()->user_type == 1)
                            <a class="headerbuttonforAdd" href="{{route('admin.users')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                        @endif
                    </h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Transaction Id</th>
                                    <th>Point</th>
                                    <th>Expiring on</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pointTransaction as $key => $point)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$point->id}}</td>
                                        <td>{{$point->points}}</td>
                                        <td>
                                            {{$point->valid_till}}
                                            @if($point->valid_till < date('Y-m-d'))
                                            {{('(Expired)')}}
                                            @endif
                                        </td>
                                        <td>{{$point->remarks}}</td>
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
