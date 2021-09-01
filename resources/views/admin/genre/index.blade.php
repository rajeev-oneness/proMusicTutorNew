@extends('layouts.auth.authMaster')
@section('title','Genre')
@section('content')

<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Genre
                        <a class="headerbuttonforAdd" href="{{route('admin.genre.create')}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add Genre
                        </a>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                	<th>#SR</th>
                                    <th>Name</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($genre as $key => $item)
                                    <tr>
                                        <td>
                                            <span class="badge badge-primary rounded-0">{{$key+1}}</span>
                                        </td>
                                        <td>
                                            {{ucwords($item->name)}}
                                        </td>
                                        <td class="text-right">
                                            <a href="{{route('admin.genre.edit', $item->id)}}" class="badge badge-dark rounded-0">Edit</a>
                                            <a href="javascript: void(0)" class="badge badge-danger rounded-0 genreDelete" data-id="{{$item->id}}">Delete</a>
                                        </td>
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

    $(document).on('click','.genreDelete',function(){
        var genreDelete = $(this);
        var genreId = $(this).attr('data-id');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this genre!",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: "{{route('admin.genre.delete',"+genreId+")}}",
                    data: {id:genreId,'_token': $('input[name=_token]').val()},
                    success:function(data){
                        if(data.error == false) {
                            genreDelete.closest('tr').remove();
                            swal('Success',"Poof! Genre has been deleted!");
                        } else {
                            swal('Error', data.message);
                        }
                    }
                });
            }
        });
    });
</script>
@stop
@endsection