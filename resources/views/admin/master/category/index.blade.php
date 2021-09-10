@extends('layouts.auth.authMaster')
@section('title','Category')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Category List
                        <a class="headerbuttonforAdd" href="{{route('admin.master.category.create')}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add Category
                        </a>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                	<th>Image</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($category as $key => $cat)
                            		<tr>
                            			<td><img src="{{asset($cat->image)}}" height="200" width="200"></td>
                            			<td>{{$cat->name}}</td>
                            			<td><a href="{{route('admin.master.category.edit',$cat->id)}}">Edit</a> | <a href="javascript:void(0)" class="text-danger categoryDelete" data-id="{{$cat->id}}">Delete</a></td>
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

        $(document).on('click','.categoryDelete',function(){
            var categoryDelete = $(this);
            var categoryId = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this category!",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'POST',
                        dataType:'JSON',
                        url:"{{route('admin.master.category.delete',"+categoryId+")}}",
                        data: {id:categoryId,'_token': $('input[name=_token]').val()},
                        success:function(data){
                            if(data.error == false){
                                categoryDelete.closest('tr').remove();
                                swal('Success',"Poof! Your Category has been deleted!");
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