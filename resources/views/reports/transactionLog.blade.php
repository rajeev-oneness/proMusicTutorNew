@extends('layouts.auth.authMaster')
@section('title','Transaction Log')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Transaction Log</h5>
                </div>
                <form method="post" action="{{route('admin.report.transaction')}}">
                    @csrf
                    <input type="text" name="teacherId" value="{{($req->teacherId ?? '')}}">
                    <input type="submit" name="">
                </form>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Series Name</th>
                                    <th>Lessions</th>
                                    <th>Description</th>
                                    <th>Media</th>
                                    <th>Author</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction as $key => $trans)
                                    <tr>{{json_encode($trans)}}</tr>
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
    </script>
@stop
@endsection
