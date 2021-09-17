@extends('layouts.auth.authMaster')
@section('title','Best seller')

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Best seller</h5>
                </div>
                <div class="card-body">
                    <p>
                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-filter"></i> Filter</button>
                    </p>
                    {{-- <div class="collapse show">
                        <div class="card card-body px-0 py-2 border-0 shadow-none">
                            <form action="" method="POST" class="form-inline">
                                <select name="" id="">

                                </select>
                            </form>
                        </div>
                    </div> --}}

                    {{-- <div class="collapse {{(isset($req->teacherId) || isset($req->seriesId) || isset($req->lessionId)) ? 'show' : ''}}" id="collapseExample">
                        <div class="card card-body px-0 py-2 border-0 shadow-none">
                            <form class="form-inline" method="post" action="{{route('admin.report.transaction')}}">
                            @csrf
                                <select name="teacherId" id="teacherId" class="form-control form-control-sm mr-2" onchange="filterSeries(this)">
                                    <option value="" disabled {{($req->teacherId) ? '' : 'selected'}}>Select tutor</option>
                                    @foreach ($teachers as $item)
                                        <option value="{{$item->id}}" {{($item->id == $req->teacherId) ? 'selected' : ''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>

                                <select name="seriesId" id="seriesId" class="form-control form-control-sm mr-2" onchange="filterLesson(this)">
                                    <option value="" hidden selected>Select series</option>
                                    @foreach ($available_series as $item)
                                        <option value="{{$item->id}}" {{($item->id == $req->seriesId) ? 'selected' : ''}}>{{$item->title}}</option>
                                    @endforeach
                                </select>

                                <select name="lessionId" id="lessionId" class="form-control form-control-sm mr-2">
                                    <option value="" hidden selected>Select lession</option>
                                    @foreach ($available_lessons as $item)
                                        <option value="{{$item->id}}" {{($item->id == $req->lessionId) ? 'selected' : ''}}>{{$item->title}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary mr-2"> <i class="fa fa-check"></i> Apply</button>
                                <a href="{{route('admin.report.transaction')}}" class="btn btn-sm btn-secondary"> <i class="fa fa-ban"></i> Remove filters</a>
                            </form>
                        </div>
                    </div> --}}

                    <div class="table-responsive">
                        <table id="example5" class="table table-sm table-hover table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Period</th>
                                    <th>Product Series</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $key => $item)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>
                                            {{$item['from']}}
                                            <span class="text-muted">To</span>
                                            {{$item['to']}}
                                        </td>
                                        <td>{{$item['seriesName']}}</td>
                                        <td>{{$item['count']}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center"><em>No record found</em></td>
                                    </tr>
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
    <script>
        
    </script>
@stop
@endsection
