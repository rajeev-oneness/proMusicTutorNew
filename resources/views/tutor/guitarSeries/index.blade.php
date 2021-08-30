@extends('layouts.auth.authMaster')
@section('title','Guitar Series')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Guitar Series List
                        <a class="headerbuttonforAdd" href="{{route('tutor.guitar.series.create')}}">
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
                                    <th>Series Lession</th>
                                    <th>Description</th>
                                    <th>Media</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guitarSeries as $key => $series)
                                    <?php   
                                        $catgeory = $series->category;
                                        $lession = $series->lession;
                                    ?>
                                    <tr>
                                        <td>{{$catgeory->name}}</td>
                                        <td><img src="{{asset($series->image)}}" height="200" width="200"></td>
                                        <td>{{ $series->title }}</td>
                                        <td><a href="{{route('tutor.guitar.series.lession',$series->id)}}">{{count($lession)}}</a></td>
                                        <td>{!! $series->description !!}</td>
                                        <td><a href="{{$series->video_url}}" target="_blank">Link</a></td>
                                        <td><a href="{{route('tutor.guitar.series.edit',$series->id)}}">Edit</a> | <a href="javascript:void(0)" class="text-danger seriesDelete" data-id="{{$series->id}}">Delete</a></td>
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
            var seriesId = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Guitar Series!",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'POST',
                        dataType:'JSON',
                        url:"{{route('tutor.guitar.series.delete',"+seriesId+")}}",
                        data: {id:seriesId,'_token': $('input[name=_token]').val()},
                        success:function(data){
                            if(data.error == false){
                                seriesDelete.closest('tr').remove();
                                swal('Success',"Poof! Your Guitar Series has been deleted!");
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