@extends('layouts.auth.authMaster')
@section('title',ucwords($instrument->name))
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ucwords($instrument->name)}} List
                        <a class="headerbuttonforAdd" href="{{route('tutor.product.series.create',[$instrument->id])}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add Series
                        </a>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Series Name</th>
                                    <th>Lessions</th>
                                    <th>Description</th>
                                    <th>Media</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productSeries as $key => $series)
                                    <?php
                                        $category = $series->category;
                                        $lession = $series->lession;
                                    ?>
                                    <tr>
                                        <td>{{$category->name}}</td>
                                        <td><img src="{{asset($series->image)}}" height="200" width="200"></td>
                                        <td>{{ $series->title }}</td>
                                        <td><a href="{{route('tutor.product.series.lession.list',[$instrument->id,$series->id])}}">{{count($lession)}} to view</a></td>
                                        <td>{!! words($series->description,350) !!}</td>
                                        <td><a href="{{$series->video_url}}" target="_blank">Link</a></td>
                                        <td><a href="{{route('tutor.product.series.edit',[$instrument->id,$series->id])}}">Edit</a> | <a href="javascript:void(0)" class="text-danger seriesDelete" data-id="{{$series->id}}">Delete</a></td>
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
                text: "Once deleted, you will not be able to recover this Series!",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'POST',
                        dataType:'JSON',
                        url:"{{route('tutor.product.series.delete',[$instrument->id])}}",
                        data: {instrumentId:'{{$instrument->id}}',productSeriesId:productSeriesId,userId:'{{$user->id}}','_token': $('input[name=_token]').val()},
                        success:function(data){
                            if(data.error == false){
                                seriesDelete.closest('tr').remove();
                                swal('Success',"Poof! Your Series has been deleted!");
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