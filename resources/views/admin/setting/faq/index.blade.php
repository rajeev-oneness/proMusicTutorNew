@extends('layouts.auth.authMaster')
@section('title','Faq')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Faq List
                        <a class="headerbuttonforAdd" href="{{route('admin.faq.create')}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add Faq
                        </a>
                    </h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($faq as $key=>$f)
                            		<tr>
                            			<td>{{$f->title}}</td>
                            			<td class="readMore">{!! $f->description !!}</td>
                            			<td><a href="{{route('admin.faq.edit',$f->id)}}"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0)" class="deleteFaq text-danger" data-id="{{$f->id}}"><i class="fas fa-trash-alt text-danger"></i></a></td>
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

        $(document).on('click','.deleteFaq',function(){
            var deleteFaq = $(this);
            var faqId = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this faq!",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'POST',
                        dataType:'JSON',
                        url:"{{route('admin.faq.delete',"+faqId+")}}",
                        data: {id:faqId,'_token': $('input[name=_token]').val()},
                        success:function(data){
                            if(data.error == false){
                                deleteFaq.closest('tr').remove();
                                swal('Success',"Poof! Your Faq has been deleted!");
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
