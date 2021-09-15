@extends('layouts.auth.authMaster')
@section('title',ucwords($instrument->name).' Lession')
@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ucwords($instrument->name)}} Lession List ({{$productSeries->title}})
                            <a class="headerbuttonforAdd" href="{{route('admin.product.series.list',[$instrument->id])}}"><i class="fa fa-step-backward" aria-hidden="true"></i>BACK</a>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example4" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Difficulty</th>
                                        <th>Description</th>
                                        <th>Author</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productSeries->lession_data as $key => $lession)
                                        <tr>
                                            <td><img src="{{asset($lession->image)}}" height="200" width="200"></td>
                                            <td>{{$lession->title}}</td>
                                            <td>€ {{$lession->price}}</td>
                                            <td>{{ucwords($lession->difficulty)}}</td>
                                            <td>{!! words($lession->description,500) !!}</td>
                                            <td>
                                                <ul>
                                                    <?php $author = $lession->author;?>
                                                    <li>Name: {{$author->name}}</li>
                                                    <li>Email: {{$author->email}}</li>
                                                </ul>
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
    </script>
@stop
@endsection