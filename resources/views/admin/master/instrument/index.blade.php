@extends('layouts.auth.authMaster')
@section('title','Instrument')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Instrument List
                        <a class="headerbuttonforAdd" href="{{route('admin.master.instrument.create')}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add Instrument
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
                            	@foreach($instrument as $key => $ins)
                            		<tr>
                            			<td><img src="{{asset($ins->image)}}" height="auto" width="100"></td>
                            			<td>{{$ins->name}}</td>
                            			<td><a href="{{route('admin.master.instrument.edit',$ins->id)}}"><i class="fas fa-edit text-primary"></i></a> | <a href="javascript:void(0)" class="text-danger instrumentDelete" data-id="{{$ins->id}}"><i class="fas fa-trash-alt text-danger"></i></a></td>
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

        $(document).on('click','.instrumentDelete',function(){
            var deleteInstrument = $(this);
            var instrumentId = $(this).attr('data-id');
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
                        url:"{{route('admin.master.instrument.delete',"+instrumentId+")}}",
                        data: {id:instrumentId,'_token': $('input[name=_token]').val()},
                        success:function(data){
                            if(data.error == false){
                                deleteInstrument.closest('tr').remove();
                                swal('Success',"Poof! Your Instrument has been deleted!");
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