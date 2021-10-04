@extends('layouts.auth.authMaster')
@section('title',ucwords($instrument->name))

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ucwords($instrument->name)}} List
                        <a class="headerbuttonforAdd" href="{{route('admin.product.series.create',[$instrument->id])}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add Series
                        </a>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-sm table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#SR</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Series</th>
                                    <th>Lessions</th>
                                    <th>Difficulty</th>
                                    <th>Description</th>
                                    <th>Media</th>
                                    <th>Author</th>
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
                                        <td>{{$key + 1}}</td>
                                        <td class="small">{{$category->name}}</td>
                                        <td><img src="{{asset($series->image)}}" height="100" width="100"></td>
                                        <td class="small">{{ $series->title }}</td>
                                        <td><a href="{{route('admin.product.series.lession.list',[$instrument->id,$series->id])}}">{{count($lession)}} to view</a></td>
                                        <td class="small">{{ucwords($series->difficulty)}}</td>
                                        <td class="small">{!! words($series->description,70) !!}</td>
                                        <td>
                                            <video controls muted height="100">
                                                <source src="{{asset($series->video_url)}}" type="video/mp4">
                                            </video>
                                            {{-- <a href="{{$series->video_url}}" target="_blank">Link</a> --}}
                                        </td>
                                        <td class="small">
                                            <ul>
                                                <?php $author = $series->author;?>
                                                <li>Name: {{$author->name}}</li>
                                                <li>Email: {{$author->email}}</li>
                                            </ul>
                                        </td>
                                        <td class="small"><a href="{{route('admin.product.series.edit',[$instrument->id,$series->id])}}">Edit</a> | <a href="javascript:void(0)" class="text-danger seriesDelete" data-id="{{$series->id}}">Delete</a></td>
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
                        url:"{{route('admin.product.series.delete',[$instrument->id])}}",
                        data: {instrumentId:'{{$instrument->id}}',productSeriesId:productSeriesId,'_token': $('input[name=_token]').val()},
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
