@extends('layouts.auth.authMaster')
@section('title','Dashboard')

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Dashboard</h5>
                </div>
                <div class="card-body">
                    <!-- <p>Welcome to the Dashboard</p> -->
                    <div class="dashboard-body-content-upper p-0">
                        <!-- <h5 class="mb-0">Instrument Product Series</h5><br> -->
                        <div class="row m-0">
                            @foreach($data->instrument as $key => $instrument)
                                <div class="col-md-3 dash-card-col">
                                    <a href="{{route('tutor.product.series.list',[$instrument->id,'instrument='.$instrument->name])}}">
                                        <div class="card card-body mb-0" style="background-image: url({{asset($instrument->image)}})">
                                            <h5 class="mb-2">{{$instrument->name}} ({{count($instrument->product)}})</h5>
                                            <p class="small mb-0">
                                                View series' list
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            <div class="col-md-3 dash-card-col">
                                <a href="{{route('tutor.offer.list')}}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Offers ({{count($data->offers)}})</h5>
                                        <p class="small mb-0">
                                            View Offers' list
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Most Viewed Series -->
                    <hr>
                    <h4>Most Viewd Series</h4>
                    {{-- <p><button class="headerbuttonforAdd d-block mb-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-filter"></i> Filter</button></p>
                    <div class="collapse show" id="collapseExample">
                        <div class="card card-body px-0 py-2 border-0 shadow-none">
                            <form action="{{url('tutor/dashboard')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="mostViewedInstrumentId">Select Instrument</label>
                                        <select name="mostViewedInstrumentId" id="mostViewedInstrumentId" class="form-control form-control-sm mr-2">
                                            <option value="" selected hidden>Select Instrument</option>
                                            @foreach ($data->instrument as $instrument)
                                                <option value="{{$instrument->id}}" {{($instrument->id == $req->mostViewedInstrumentId) ? 'selected' : ''}}>{{$instrument->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
    
                                    <div class="col-md-3">
                                        <label for="mostViewedDateFrom">Date from</label>
                                        <input type="date" class="form-control form-control-sm mr-2" placeholder="Date from" name="mostViewedDateFrom" id="mostViewedDateFrom" max="{{date('Y-m-d')}}" value="{{($req->mostViewedDateFrom ?? '')}}">
                                    </div>
    
                                    <div class="col-md-3">
                                        <label for="mostViewedDateTo">Date to</label>
                                        <input type="date" class="form-control form-control-sm mr-2" placeholder="Date to" name="mostViewedDateTo" id="mostViewedDateTo" max="{{date('Y-m-d')}}" value="{{($req->mostViewedDateTo ?? '')}}">
                                    </div>

                                    <div class="col-md-3 text-right">
                                        <div style="margin-top: 30px"></div>
                                        <button type="submit" class="btn btn-sm btn-primary mr-2"> <i class="fa fa-check"></i> Apply</button>
                                        <a href="{{url('tutor/dashboard')}}" class="btn btn-sm btn-secondary"> <i class="fa fa-ban"></i> Remove filters</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                    <div class="table-responsive">
                        <table id="example5" class="table table-sm table-hover table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Period</th>
                                    <th>Instrument</th>
                                    <th>Product Series</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->mostViewed as $key => $item)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>
                                            {{ date('j M, Y g:i a', strtotime($item->created_at)) }}
                                            <span class="text-muted">To</span>
                                            {{ date('j M, Y g:i a', strtotime($item->last_count_increased_at)) }}
                                        </td>
                                        <td>{{$item->instrument_all->name}}</td>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->view_count}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center"><em>No record found</em></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="float-right">{{ $data->mostViewed->appends(request()->query())->links() }}</div>
                    <!-- Most Viewed Series End-->

                    <!-- Selling Report -->
                    <hr>
                    <h4>Transaction Log</h4>
                    <div class="table-responsive">
                        <table id="example5" class="table table-sm table-hover table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Transaction Id</th>
                                    <th>Amount</th>
                                    <th>Offers</th>
                                    <th>Series</th>
                                    <th>Lesson</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->transactionLog as $index => $transaction_log)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$transaction_log['transaction']->transactionId}}</td>
                                        <td>{{currencySymbol($transaction_log['transaction']->currency)}} {{$transaction_log['transaction']->amount / 100}}</td>
                                        <td>
                                            @php $objectOffers = (object)$transaction_log['offers']; @endphp
                                            @if(count($objectOffers) > 0)
                                                <a href="javascript:void(0)" class="viewPurchaseDetails" data-details="{{json_encode($objectOffers)}}" data-userfor="offer">view</a>
                                            @else
                                                {{('N/A')}}
                                            @endif
                                        </td>
                                        <td>
                                            @php $objectSeries = (object)$transaction_log['series']; @endphp
                                            @if(count($objectSeries) > 0)
                                                <a href="javascript:void(0)" class="viewPurchaseDetails" data-details="{{json_encode($objectSeries)}}" data-userfor="series">view</a>
                                            @else
                                                {{('N/A')}}
                                            @endif
                                        </td>
                                        <td>
                                            @php $objectLession = (object)$transaction_log['lession']; @endphp
                                            @if(count($objectLession) > 0)
                                                <a href="javascript:void(0)" class="viewPurchaseDetails" data-details="{{json_encode($objectLession)}}" data-userfor="lession">view</a>
                                            @else
                                                {{('N/A')}}
                                            @endif
                                        </td>
                                        <td>{{$transaction_log['date']}}</td>
                                        <td>{{$transaction_log['time']}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center"><em>No record found</em></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="float-right">{{ $data->transactionLog->appends(request()->query())->links() }}</div> --}}
                    <!-- Selling Report End -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="userPurchaseModalHeading" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userPurchaseModalHeading">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                    </tr>
                    <tbody id="userPurchaseDataHistory"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@section('script')
<script type="text/javascript">
    $(document).on('click','.viewPurchaseDetails',function(){
        var useFor = $(this).attr('data-userfor'),userPurchaseModalHeading = '',dataToPush = '';
        var allData = JSON.parse($(this).attr('data-details'));
        if(useFor == 'lession'){
            userPurchaseModalHeading = 'Lesson Purchase';
            $.each(allData,function(key,value){
                dataToPush += '<tr><td><img height="70" width="100" src="{{url('')}}/'+value?.product_series_lession_all?.image+'"></td><td>'+value?.product_series_lession_all?.title+'</td></tr>';
            });
        }else if(useFor == 'series'){
            userPurchaseModalHeading = 'Series Purchase';
            $.each(allData,function(key,value){
                dataToPush += '<tr><td><img height="70" width="100" src="{{url('')}}/'+value?.product_series_all?.image+'"></td><td>'+value?.product_series_all?.title+'</td></tr>';
            });
        }else if(useFor == 'offer'){
            userPurchaseModalHeading = 'Offer Purchase';
            $.each(allData,function(key,value){
                dataToPush += '<tr><td><img height="70" width="100" src="{{url('')}}/'+value?.offers_details_all?.image+'"></td><td>'+value?.offers_details_all?.title+'</td></tr>';
            });
        }
        console.log(allData);
        $('#exampleModal #userPurchaseDataHistory').empty().append(dataToPush);
        $('#exampleModal #userPurchaseModalHeading').text(userPurchaseModalHeading);
        $('#exampleModal').modal('show');
    });
</script>
@stop
@endsection