@extends('layouts.auth.authMaster')
@section('title','Guitar Series')
@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Guitar Series List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Series Name</th>
                                    <th>Series Lession</th>
                                    <th>Description</th>
                                    <th>Media</th>
                                    <th>Author</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guitarSeries as $key => $series)
                                    <?php
                                        $catgeory = $series->category;
                                        $lession = $series->lession;
                                    ?>
                                    <tr>
                                        <td>{{$catgeory->name}}</td>
                                        <td><img src="{{asset($series->image)}}" height="200" width="200"></td>
                                        <td>{{ $series->title }}</td>
                                        <td>
                                            <a href="{{route('admin.guitar.series.lession.view',$series->id)}}">{{count($lession)}}</a>
                                        </td>
                                        <td>{!! $series->description !!}</td>
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