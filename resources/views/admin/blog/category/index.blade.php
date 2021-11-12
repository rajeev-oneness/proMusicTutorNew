@extends('layouts.auth.authMaster')
@section('title','Blog Category')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Blog Category
                        <a class="headerbuttonforAdd addBlogCategory" href="javascript:void(0)">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add Blog Category
                        </a>
                    </h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Category Id</th>
                                    <th>Name</th>
                                    <th>No. Of Blogs</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->category as $cat)
                                    <tr>
                                        <td>#{{$cat->id}}</td>
                                        <td>{{$cat->title}}</td>
                                        <th><a href="{{route('admin.blog.data.list',['categoryId'=>$cat->id,'categoryName'=>$cat->title])}}">{{count($cat->blogs_data)}}</a></th>
                                        <td>
                                            <a href="javascript:void(0)" class="editBlogCategory" data-id="{{$cat->id}}" data-name="{{$cat->title}}"><i class="fa fa-edit"></i></a> | <a href="javascript:void(0)" class="deleteBlogCategory text-danger" data-id="{{$cat->id}}"><i class="fa fa-trash"></i></a>
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

<!--Add Blog Category Modal -->
<div class="modal fade" id="addBlogCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Blog Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{route('admin.blog.category.save')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name'){{('is-invalid')}}@enderror" placeholder="Category name" maxlength="255" value="{{old('name')}}" required="">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Edit Blog Category Modal -->
<div class="modal fade" id="editBlogCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Blog Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{route('admin.blog.category.update')}}">
                @csrf
                <input type="hidden" name="blogCategoryId" id="blogCategoryId" value="{{(old('blogCategoryId') ?? 0)}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="updateBlogname">Name</label>
                        <input type="text" name="updatename" id="updatename" class="form-control @error('updatename'){{('is-invalid')}}@enderror" placeholder="Category name" maxlength="255" value="{{old('updatename')}}">
                        @error('updatename')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('script')
    <script type="text/javascript">

        @error('name')
            $('#addBlogCategoryModal').modal('show');
        @enderror

        $(document).on('click','.addBlogCategory',function(){
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $('#addBlogCategoryModal input[name=name]').val('');
            $('#addBlogCategoryModal').modal('show');
        });

        @error('updatename')
            $('#editBlogCategoryModal').modal('show');
        @enderror

        $(document).on('click','.editBlogCategory',function(){
            var id = $(this).attr('data-id'),name = $(this).attr('data-name');
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $('#editBlogCategoryModal input[name=blogCategoryId]').val(id);
            $('#editBlogCategoryModal input[name=updatename]').val(name);
            $('#editBlogCategoryModal').modal('show');
        });

        $(document).on('click','.deleteBlogCategory',function(){
            var deleteBlogCategory = $(this);
            var blogCategoryId = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this blog category!",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'POST',
                        dataType:'JSON',
                        url:"{{route('admin.blog.category.delete',"+blogCategoryId+")}}",
                        data: {id:blogCategoryId,'_token': $('input[name=_token]').val()},
                        success:function(data){
                            if(data.error == false){
                                deleteBlogCategory.closest('tr').remove();
                                swal('Success',"Poof! Your blog category has been deleted!");
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
