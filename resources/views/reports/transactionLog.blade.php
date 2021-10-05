@extends('layouts.auth.authMaster')
@section('title','Sales Report')

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Sales Report</h5>
                </div>
                <div class="card-body">
                    <p>
                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-filter"></i> Filter</button>
                    </p>
                    <div class="collapse show" id="collapseExample">
                    {{-- <div class="collapse {{(isset($req->teacherId) || isset($req->seriesId) || isset($req->lessionId)) ? 'show' : ''}}" id="collapseExample"> --}}
                        <div class="card card-body px-0 py-2 border-0 shadow-none">
                            <form class="form-inline" method="post" action="{{route('admin.report.transaction')}}">
                            @csrf
                            
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
                                <!-- <input type="text" class="form-control form-control-sm mr-2" name="keyword" placeholder="Type something..." value="{{$req->keyword}}"> -->
                                <button type="submit" class="btn btn-sm btn-primary mr-2"> <i class="fa fa-check"></i> Apply</button>
                                <a href="{{route('admin.report.transaction')}}" class="btn btn-sm btn-secondary"> <i class="fa fa-ban"></i> Remove filters</a>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="example5" class="table table-sm table-hover table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>User info</th>
                                    <th>Purchase</th>
                                    <th>Title</th>
                                    <th>TXN_ID</th>
                                    <th>TXN_AMOUNT</th>
                                    <th>Purchase date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userPurchase as $key => $item)
                                    <tr>
                                        <td>{{$key +1}}</td>
                                        <td>
                                            <div class="media">
                                                <img class="mr-3 rounded-circle" src="{{asset($item->users_details_all->image)}}" alt="user-image" style="height: 50px;width: 50px;">
                                                <div class="media-body">
                                                    <p class="mb-0">{{$item->users_details_all->name}}</p>
                                                    <p class="text-muted mb-0">{{$item->users_details_all->email}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{strtoupper($item->type_of_purchase)}}</td>
                                        <td>
                                            @if($item->type_of_purchase == 'offer')
                                                {{$item->offer_data->title}}
                                            @elseif($item->type_of_purchase == 'series')
                                                {{$item->series_data->title}}
                                            @elseif($item->type_of_purchase == 'lession')
                                                {{$item->lession_data->title}}
                                            @endif
                                        </td>
                                        <td>{{$item->transaction->transactionId}}</td>
                                        <td>{{currencySymbol($item->transaction->currency)}} {{number_format($item->transaction->amount / 100,2)}}</td>
                                        <td>{{date('M d, Y h:i A',strtotime($item->transaction->created_at))}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center text-muted"><em>No record found</em></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="test float-right">
                            {{$userPurchase->links()}}
                        </div>
                    </div>

                    {{-- <div class="table-responsive">
                        <table id="example5" class="table table-sm table-hover table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>User info</th>
                                    <th>Product Series</th>
                                    <th>Lesson info</th>
                                    <th>TXN_ID</th>
                                    <th>TXN_AMOUNT</th>
                                    <th>Purchase date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaction as $key => $item)
                                <tr>
                                    <td>{{$key +1}}</td>
                                    <td>
                                        <div class="media">
                                            <img class="mr-3 rounded-circle" src="{{asset($item->users_details->image)}}" alt="user-image" style="height: 50px;width: 50px;">
                                            <div class="media-body">
                                                <p class="mb-0">{{$item->users_details->name}}</p>
                                                <p class="text-muted mb-0">{{$item->users_details->email}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">{{$item->product_series->title}}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">{{$item->product_series_lession->title}}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">#{{$item->transactionId}}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">${{$item->product_series_lession->price}}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">{{date('j M, Y g:i a', strtotime($item->created_at))}}</p>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center text-muted"><em>No record found</em></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="test float-right">
                            {{$transaction->links()}}
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        function filterSeries(teacher) {
            var options = '<option value="" hidden selected>Select series</option>';
            @foreach($available_series as $series)
                if(parseInt('{{$series->createdBy}}') == parseInt(teacher.value)) {
                    options += '<option value="{{$series->id}}">{{$series->title}}</option>';
                }
            @endforeach
            $('#seriesId').empty().append(options);
            $('#lessionId').empty().append('<option value="" hidden selected>Select lession</option>');
        }

        function filterLesson(series) {
            var options = '<option value="" hidden selected>Select lession</option>';
            @foreach($available_lessons as $lessons)
                if(parseInt('{{$lessons->productSeriesId}}') == parseInt(series.value)) {
                    options += '<option value="{{$lessons->id}}">{{$lessons->title}}</option>';
                }
            @endforeach
            $('#lessionId').empty().append(options);
        }
    </script>
@stop
@endsection
