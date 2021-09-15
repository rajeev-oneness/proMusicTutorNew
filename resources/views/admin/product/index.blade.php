@extends('layouts.auth.authMaster')
@section('title',ucwords($instrument->name))
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ucwords($instrument->name)}} List</h5>
                </div>
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
                                @foreach($productSeries as $key => $series)
                                    <?php
                                        $category = $series->category;
                                        $lession = $series->lession;
                                    ?>
                                    <tr>
                                        <td>{{$category->name}}</td>
                                        <td><img src="{{asset($series->image)}}" height="200" width="200"></td>
                                        <td>{{ $series->title }}</td>
                                        <td><a href="{{route('admin.product.series.lession.list',[$instrument->id,$series->id])}}">{{count($lession)}} to view</a></td>
                                        <td>{!! words($series->description,350) !!}</td>
                                        <td><a href="{{$series->video_url}}" target="_blank">Link</a></td>
                                        <td>
                                            <ul>
                                                <?php $author = $series->author;?>
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
