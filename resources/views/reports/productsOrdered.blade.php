@extends('layouts.auth.authMaster')
@section('title','Products ordered')

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Products ordered (Lessions)</h5>
                </div>
                <div class="card-body">
                    <p>
                        <button class="headerbuttonforAdd d-block mb-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-filter"></i> Filter</button>
                    </p>
                    <div class="collapse hide" id="collapseExample">
                        <div class="card card-body px-0 py-2 border-0 shadow-none">
                            <form action="{{route('admin.report.productsOrdered')}}" method="POST">
                            @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="instrumentId">Select Instrument</label>
                                        <select name="instrumentId" id="instrumentId" class="form-control form-control-sm mr-2">
                                            <option value="" selected hidden>Select Instrument</option>
                                            @foreach ($instruments as $instrument)
                                                <option value="{{$instrument->id}}" {{($instrument->id == $req->instrumentId) ? 'selected' : ''}}>{{$instrument->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="dateFrom">Date from</label>
                                        <input type="date" class="form-control form-control-sm mr-2" placeholder="Date from" name="dateFrom" id="dateFrom" max="{{date('Y-m-d')}}" value="{{(!empty($req->dateFrom)) ? $req->dateFrom : ''}}">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="dateTo">Date to</label>
                                        <input type="date" class="form-control form-control-sm mr-2" placeholder="Date to" name="dateTo" id="dateTo" max="{{date('Y-m-d')}}" value="{{(!empty($req->dateTo)) ? $req->dateTo : ''}}">
                                    </div>

                                    <div class="col-md-3 text-right">
                                        <div style="margin-top: 30px"></div>
                                        <button type="submit" class="btn btn-sm btn-primary mr-2"> <i class="fa fa-check"></i> Apply</button>
                                        <a href="{{route('admin.report.productsOrdered')}}" class="btn btn-sm btn-secondary"> <i class="fa fa-ban"></i> Remove filters</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="example5" class="table table-sm table-hover table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Period</th>
                                    <th>Lession</th>
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
                                        <td>{{$item['lessonName']}}</td>
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
