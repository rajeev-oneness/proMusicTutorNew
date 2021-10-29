@extends('layouts.auth.authMaster')
@section('title','Dashboard')
@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Dashboard</h5>
                </div>
                <div class="card-body">
                    <p>Welcome to the Dashboard</p>
                    <h4>Your Transaction Log</h4>
                    <div class="table-responsive">
                        <table id="example5" class="table table-sm table-hover table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Transaction Id</th>
                                    <th>Amount</th>
                                    <th>Offers</th>
                                    <th>Series</th>
                                    <th>Lession</th>
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
            userPurchaseModalHeading = 'Lession Purchase';
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
        // console.log(allData);
        $('#exampleModal #userPurchaseDataHistory').empty().append(dataToPush);
        $('#exampleModal #userPurchaseModalHeading').text(userPurchaseModalHeading);
        $('#exampleModal').modal('show');
    });
</script>
@stop
@endsection