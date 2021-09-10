@extends('layouts.auth.authMaster')
@section('title','Guitar Lession')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Guitar Lession List ({{$guitarSeries->title}})
                            <a class="headerbuttonforAdd" href="{{route('tutor.guitar.series')}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                            <a class="headerbuttonforAdd" href="{{route('tutor.guitar.series.lession.create',$guitarSeries->id)}}">
                                <i class="fa fa-plus" aria-hidden="true"></i>Add Lession
                            </a>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example4" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>GBP</th>
                                        <th>USD</th>
                                        <th>EURO</th>
                                        <th>Keywords</th>
                                        <th>Genre</th>
                                        <th>Item clean URL</th>
                                        <th>Product code</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($guitarSeries->lession as $key => $lession)
                                        <tr>
                                            <td><img src="{{asset($lession->image)}}" height="200" width="200"></td>
                                            <td>{{$lession->title}}</td>
                                            <td>{{$lession->price}}</td>
                                            <td>{{$lession->gbp}}</td>
                                            <td>{{$lession->price_usd}}</td>
                                            <td>{{$lession->price_euro}}</td>
                                            <td>{{$lession->keywords}}</td>
                                            <td>{{ ($lession->genre_data ? $lession->genre_data->name : '') }}</td>
                                            <td>{{$lession->item_clean_url}}</td>
                                            <td>{{$lession->product_code}}</td>
                                            <td>{!! words($lession->description,20) !!}</td>
                                            <td><a href="{{route('tutor.guitar.series.lession.edit',[$guitarSeries->id,$lession->id])}}">Edit</a> | <a href="javascript:void(0)" class="text-danger seriesLessionDelete" data-id="{{$lession->id}}">Delete</a></td>
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
                text: "Once deleted, you will not be able to recover this Guitar Lession!",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'POST',
                        dataType:'JSON',
                        url:"{{route('tutor.guitar.series.lession.delete',[$guitarSeries->id,"+seriesLessionId+"])}}",
                        data: {id:seriesLessionId,'_token': $('input[name=_token]').val()},
                        success:function(data){
                            if(data.error == false){
                                seriesLessionDelete.closest('tr').remove();
                                swal('Success',"Poof! Your Guitar Series Lession has been deleted!");
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
