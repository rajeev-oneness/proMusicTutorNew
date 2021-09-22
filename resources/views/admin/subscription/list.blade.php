@extends('layouts.auth.authMaster')
@section('title','Subscription List')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Subscription
                        <a class="headerbuttonforAdd" href="{{route('admin.master.subscription.create')}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add Subscription
                        </a>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Features</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subscription as $key => $subscription)
                                    <tr>
                                        <td>{{$subscription->title}}</td>
                                        <td><img src="{{asset($subscription->image)}}" height="200" width="200"></td>
                                        <td>{{ $subscription->price }}</td>
                                        <td>
                                            <ul>
                                                @foreach($subscription->features as $features)
                                                    <li>{{$features->title}}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td><a href="{{route('admin.master.subscription.edit',[$subscription->id,'title'=>$subscription->title])}}">Edit</a> | <a href="javascript:void(0)" class="text-danger seriesDelete" data-id="{{$subscription->id}}">Delete</a></td>
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

        $(document).on('click','.seriesDelete',function(){
            var seriesDelete = $(this);
            var productSeriesId = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Subscription!",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'POST',
                        dataType:'JSON',
                        url:"{{route('admin.master.subscription.delete')}}",
                        data: {id:productSeriesId,_token:'{{csrf_token()}}'},
                        success:function(data){
                            if(data.error == false){
                                seriesDelete.closest('tr').remove();
                                swal('Success',"Poof! Your Subscription has been deleted!");
                            }else{
                                swal('Error',data.message);
                            }
                        }
                    });
                    
                }
            });
        });
    </script>
@stop
@endsection