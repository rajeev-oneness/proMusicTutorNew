@extends('layouts.auth.authMaster')
@section('title',ucwords($instrument->name).' Lession')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ucwords($instrument->name)}} Lession List ({{$productSeries->title}})
                            <a class="headerbuttonforAdd" href="{{route('admin.product.series.list',[$instrument->id])}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                            <a class="headerbuttonforAdd" href="{{route('admin.product.series.lession.create',[$instrument->id,$productSeries->id])}}">
                                <i class="fa fa-plus" aria-hidden="true"></i>Add Lession
                            </a>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example4" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#SR</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Difficulty</th>
                                        <th>Description</th>
                                        <th>Author</th>
                                        <th>Preview video</th>
                                        <th>Lesson video</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productSeries->lession_data as $key => $lession)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td><img src="{{asset($lession->image)}}" height="200" width="200"></td>
                                            <td>{{$lession->title}}</td>
                                            <td>€ {{$lession->price}}</td>
                                            <td>{{ucwords($lession->difficulty)}}</td>
                                            <td>{!! words($lession->description,100) !!}</td>
                                            <td>
                                                <ul>
                                                    <?php $author = $lession->author;?>
                                                    <li>Name: {{$author->name}}</li>
                                                    <li>Email: {{$author->email}}</li>
                                                </ul>
                                            </td>
                                            <td>
                                                @if ($lession->preview_video)
                                                <video height="100" controls>
                                                    <source src="{{asset($lession->preview_video)}}">
                                                </video>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($lession->preview_video)
                                                <video height="100" controls>
                                                    <source src="{{asset($lession->video)}}">
                                                </video>
                                                @endif
                                            </td>
                                            <td><a href="{{route('admin.product.series.lession.edit',[$instrument->id,$productSeries->id,$lession->id])}}">Edit</a> | <a href="javascript:void(0)" class="text-danger seriesLessionDelete" data-id="{{$lession->id}}">Delete</a></td>
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

        $(document).on('click','.seriesLessionDelete',function(){
            var seriesLessionDelete = $(this);
            var seriesLessionId = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Product Lession!",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'POST',
                        dataType:'JSON',
                        url:"{{route('admin.product.series.lession.delete',[$instrument->id,$productSeries->id])}}",
                        data: {
                            instrumentId:'{{$instrument->id}}',
                            productSeriesId:'{{$productSeries->id}}',
                            seriesLessionId:seriesLessionId,
                            '_token': $('input[name=_token]').val()
                        },
                        success:function(data){
                            if(data.error == false){
                                seriesLessionDelete.closest('tr').remove();
                                swal('Success',"Poof! Your Product Series Lession has been deleted!");
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