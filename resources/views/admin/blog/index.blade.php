@extends('layouts.auth.authMaster')
@section('title','Blogs')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Blogs
                        <a class="headerbuttonforAdd addBlogCategory" href="{{route('admin.blog.data.create')}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add Blog
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
                                	<th>Category</th>
                                    <th>Tags</th>
                                	<th>Description</th>
                                	<th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->blogs as $blog)
                                    <tr>
                                    	<td><img src="{{asset($blog->image)}}"></td>
                                    	<td>{{$blog->title}}</td>
                                    	<td>{{($blog->blog_category ? $blog->blog_category->title : 'N/A')}}</td>
                                        <td style="width: 10%!important">
                                            <ul>
                                                @forelse($blog->blog_tags as $tagKey => $tags)
                                                    <li>{{$tagKey + 1}}:{{$tags->title}}</li>.
                                                @empty
                                                    <li>{{('N/A')}}</li>
                                                @endforelse
                                            </ul>
                                        </td>
                                    	<td>{!! words($blog->description, 300) !!}</td>
                                    	<td>
                                            <a href="{{route('admin.blog.data.edit',[$blog->id,'title' => $blog->title])}}"><i class="fa fa-edit"></i></a> | <a href="javascript:void(0)" class="deleteBlogData text-danger" data-id="{{$blog->id}}"><i class="fa fa-trash"></i></a>
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
        $(document).on('click','.deleteBlogData',function(){
            var deleteBlogData = $(this);
            var blogId = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this blog!",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'POST',
                        dataType:'JSON',
                        url:"{{route('admin.blog.data.delete',"+blogId+")}}",
                        data: {id:blogId,'_token': '{{csrf_token()}}'},
                        success:function(data){
                            if(data.error == false){
                                deleteBlogData.closest('tr').remove();
                                swal('Success',"Poof! Your blog has been deleted!");
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