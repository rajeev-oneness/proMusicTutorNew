@extends('layouts.auth.authMaster')
@section('title','My Favourite')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Favourite List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Product Id</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userWishlist->user_wish_list as $key => $wishlist)
                                    @if($product = $wishlist->wishlist_series)
                                        <tr>
                                            <td>#{{$product->id}}</td>
                                            <td>{{$product->title}}</td>
                                            <td><a href="{{route('user.wishlist.remove',[$wishlist->id,$userWishlist->id])}}" data-id="{{$wishlist->id}}"><i class="fas fa-trash-alt"></i></a></td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td>No Data Found</td>
                                    <tr>
                                @endforelse
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
    </script>
@stop
@endsection
