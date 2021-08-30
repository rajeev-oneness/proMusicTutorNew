@extends('layouts.auth.authMaster')
@section('title','Contact Us')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Contact Us List</h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Contact at</th>
                                    <th>Contacted By</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contactUs as $contact)
                                    <tr>
                                        <td>{{$contact->name}}</td>
                                        <td>{{$contact->email}}</td>
                                        <td>{{$contact->phone}}</td>
                                        <td>{{$contact->description}}</td>
                                        <td>{{$contact->created_at->diffForHumans()}}</td>
                                        <td>
                                            <?php $contactBy = $contact->contactBy;?>
                                            @if($contactBy)
                                                <a href="javascript:void(0)" class="seeDetails" data-id="{{$contactBy->id}}" data-name="{{$contactBy->name}}" data-email="{{$contactBy->email}}" data-mobile="{{$contactBy->mobile}}">{{$contactBy->name}}</a>
                                            @else
                                                <a href="javascript:void(0)" class="contactUpdate" data-id="{{$contact->id}}">N/A</a>
                                            @endif
                                        </td>
                                        <td>{{$contact->remarks}}</td>
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

<!-- See Details of Contacted By -->
<div class="modal" id="seeDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Details of the Contacted Person</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>User Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="seeDetailsOfUser"></tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Submit the Remarks when Contacted -->
<div class="modal" id="submitContact" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contact Claimed Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{route('admin.report.contactUsSaveRemark')}}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="contactUsId" value="">
                    <div class="form-group">
                        <label for="remark">Remark</label>
                        <input type="text" name="remark" class="form-control" id="remark" placeholder="Your remark" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example4').DataTable();
        });

        $(document).on('click','.seeDetails',function(){
            var Id = $(this).attr('data-id'),name = $(this).attr('data-name'),email = $(this).attr('data-email'),mobile = $(this).attr('data-mobile');
            var data = '<td>'+Id+'</td><td>'+name+'</td><td>'+email+'</td><td>'+mobile+'</td>';
            $('#seeDetails #seeDetailsOfUser').empty().append(data);
            $('#seeDetails').modal('show');
        });
        $(document).on('click','.contactUpdate',function(){
            var id = $(this).attr('data-id');
            $('#submitContact input[name=contactUsId]').val(id);
            $('#submitContact #remark').val('');
            $('#submitContact').modal('show');
        });
    </script>
@stop
@endsection
