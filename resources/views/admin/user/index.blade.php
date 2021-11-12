@extends('layouts.auth.authMaster')
@section('title','Users')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{$userType}} List
                        <a class="headerbuttonforAdd" href="{{route('admin.user.create')}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add {{$userType}}
                        </a>
                    </h5>
                    <!-- <p>This example shows FixedHeader being styled by the Bootstrap 4 CSS framework.</p> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-sm table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#SR</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    @if($userType == 'Students')
                                        <th>Wishlist</th>
                                    @endif
                                    <th>Referral Code</th>
                                    <th>Referred By</th>
                                    <th>Referred To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $user)
                                    @if($user->user_type != 1)
                                        <tr>
                                            <td>
                                                <span class="badge badge-dark">{{$key + 1}}</span>
                                            </td>
                                            <td class="text-center">
                                                <img height="50" src="{{asset($user->image)}}">
                                            </td>
                                            <td>
                                                <p class="small text-dark">{{$user->name}}</p>
                                            </td>
                                            <td class="text-center align-middle">
                                                @if ($user->user_type == 2)
                                                    <span class="badge badge-success">Tutor</span>
                                                @else
                                                    <span class="badge badge-secondary">Student</span>
                                                @endif
                                            </td>
                                            <td>
                                                <p class="small text-dark">{{$user->email}}</p>
                                            </td>
                                            <td>
                                                <p class="small text-dark">{{$user->mobile}}</p>
                                            </td>
                                            @if($userType == 'Students')
                                                <td>
                                                    @if(count($user->user_wish_list) > 0)
                                                        <a href="{{route('user.wishlist',[$user->id])}}" target="_blank">view</a>
                                                    @else
                                                        {{'N/A'}}
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                <p class="small text-muted">{{$user->referral_code}}</p>
                                            </td>
                                            <td>
                                                <p class="small text-dark">
                                                @if($user->referred_through)
                                                    <a href="javascript:void(0)" class="getReferredByDetails" data-details="{{json_encode($user->referred_through)}}">view</a>
                                                @else
                                                    {{('N/A')}}
                                                @endif
                                                </p>
                                            </td>
                                            <td>
                                                <p class="small text-dark">
                                                @if(count($user->referred_to) > 0)
                                                    <a href="{{route('admin.referral.referred_to',$user->id)}}">{{count($user->referred_to)}}</a>
                                                @else
                                                    {{('N/A')}}
                                                @endif
                                                </p>
                                            </td>
                                            @if($user->user_type == 1)
                                                <td></td>
                                            @else
                                                <td>
                                                    <?php $action = 'Block';
                                                        if($user->status != 1){
                                                            $action = 'Unblock';
                                                        }
                                                    ?>
                                                    <a href="javascript:void(0)" class="badge badge-dark blockUnblock" data-id="{{$user->id}}">{{$action}}</a><br>
                                                    <a href="{{route('admin.user.edit', $user->id)}}"><i class="fas fa-edit text-primary"></i></a>
                                                    <a href="javascript:void(0)" data-id="{{$user->id}}" class="userDelete"><i class="fas fa-trash-alt text-danger"></i></a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="referredByModal" tabindex="-1" role="dialog" aria-labelledby="referredByModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="referredByModalLabel">Referred By</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="referredByData"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script type="text/javascript">
        $(document).on('click','.getReferredByDetails',function(){
            var details = JSON.parse($(this).attr('data-details'));
            var data = '<h3>Name : '+details.name+'</h3>';
            data += '<h3>Email : '+details.email+'</h3>';
            data += '<h3>Phone : '+details.mobile+'</h3>';
            data += '<h3>Referral Code : '+details.referral_code+'</h3>';
            $('#referredByModal #referredByData').empty().append(data);
            $('#referredByModal').modal('show');
        });

        $(document).on('click','.userDelete',function(){
            var userId = $(this).attr('data-id');
            var thisClickedbtn = $(this);
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this user!",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    allinOneManageUsers(userId,'delete',thisClickedbtn)
                }
            });
        });

        $(document).on('click','.blockUnblock',function(){
            var userId = $(this).attr('data-id');
            var thisClickedbtn = $(this);
            var action = 'unblock';
            if(thisClickedbtn.text() == 'Block'){
                action = 'block';
            }
            allinOneManageUsers(userId,action,thisClickedbtn);
        });

        function allinOneManageUsers(userId,action,clickedBtn)
        {
            $('.loading-data').show();
            $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.user.manageUser')}}",
                data: {userId:userId,action:action,'_token': $('input[name=_token]').val()},
                success:function(data){
                    if(data.error == false){
                        if(action == 'delete'){
                            clickedBtn.closest('tr').remove();
                            swal('Success',"Poof! Your user has been deleted!");
                        }else{
                            if(action == 'block'){
                                clickedBtn.text('Unblock');
                            }else{
                                clickedBtn.text('Block');
                            }
                        }
                    }else{
                        swal('Error',data.message);
                    }
                    $('.loading-data').hide();
                }
            });
        }

    </script>
@stop
@endsection
