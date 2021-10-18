@extends('layouts.auth.authMaster')
@section('title','Lession')
@section('content')
<style>
    .single-purchase-card {
        overflow: hidden;
        font-family: sans-serif;
    }
    .single-purchase-card .purchase-short-history {
        overflow: hidden;
    }
    .single-purchase-card .top-image{
        height: 100px;
        margin: 20px;
        transform: rotate(-5deg) scale(3);
        opacity: 0.3;
        transition: all 0.5s ease;
    }
    .single-purchase-card:hover .top-image {
        opacity: 1;
    }
    .single-purchase-card .purchase-type{
        text-transform: uppercase;
        font-family: inherit;
        font-weight: 600;
        color: #302f2f;
        margin-top: 5px;
        margin-bottom: 7px;
    }
    .single-purchase-card .txn-details {
        color: #505050;
        font-weight: 400;
        font-size: 13px;
        margin-bottom: 3px;
    }
    .single-purchase-card .txn-details p {
        margin-bottom: inherit;
    }
    .single-purchase-card .txn-details .title {
        color: #211e1e;
    }
    .single-purchase-card .purchase-list .accordion .card-header {
        cursor: pointer;
    }
    .single-purchase-card .purchase-list .accordion .card-header a {
        color: #211e1e;
        text-decoration: none;
    }
    .single-purchase-card .purchase-list .accordion .single-lesson {
        
    }
    .single-purchase-card .purchase-list .accordion .single-lesson {
        /* display: flex; */
        font-size: 14px;
    }
    .single-purchase-card .purchase-list .accordion .single-lesson .count {
        font-size: inherit;
        font-weight: 700;
        padding: 3px 5px;
    }
    .single-purchase-card .purchase-list .accordion .single-lesson .difficulty {
        background-color: #eb3601;
        color: #fff;
        padding: 3px 5px;
        font-size: inherit;
        text-transform: uppercase;
        display: inline-block;
    }
    .single-purchase-card .purchase-list .accordion .single-lesson .lesson-title {
        font-size: inherit;
        font-weight: 700;
        padding: 3px 5px;
    }
    .play-controller {
        text-align: right;
    }
</style>

<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order History</h5>
                </div>
                <div class="card-body">
                    @if(count($data) > 0)
                        <div class="accordion" id="accordionExample">
                            @foreach($data as $index => $purchase)
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$index}}" aria-expanded="true" aria-controls="collapseOne">
                                              Transaction Id : #{{$purchase['transaction']->transactionId}}  -  {{currencySymbol($purchase['transaction']->currency)}}{{number_format($purchase['transaction']->amount / 100,2)}}
                                              <span class="float-right">{{date('M d, Y h:i A',strtotime($purchase['transaction']->created_at))}}</span>
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapse{{$index}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            @if(count($purchase['offers']) > 0)
                                                <div class="accordion" id="accordionExampleOffersOnly">
                                                    @foreach($purchase['offers'] as $offersIndex => $purchaseOffers)
                                                        @php $productOffer = $purchaseOffers->offers_details_all; @endphp
                                                        <div class="card">
                                                            <div class="card-header" id="headingOfferOnly">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOffer{{$offersIndex}}" aria-expanded="true" aria-controls="collapseOne">Offer : {{$productOffer->title}}</button>
                                                                </h2>
                                                            </div>
                                                            <div id="collapseOffer{{$offersIndex}}" class="collapse" aria-labelledby="headingOfferOnly" data-parent="#accordionExampleOffersOnly">
                                                                <div class="card-body">
                                                                    <div class="accordion" id="accordionExampleOfferSeriesOnly">
                                                                        @foreach(getPurchaseSeriesUnderOffer($purchaseOffers) as $offerSeriesIndex => $purchaseSeries)
                                                                            @php $offerSeries = $purchaseSeries->product_series_all; @endphp
                                                                            <div class="card">
                                                                                <div class="card-header" id="headingOfferSeriesOnly">
                                                                                    <h2 class="mb-0">
                                                                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOfferSeries{{$offerSeriesIndex}}" aria-expanded="true" aria-controls="collapseOne">Series : {{$offerSeries->title}}</button>
                                                                                    </h2>
                                                                                </div>
                                                                                <div id="collapseOfferSeries{{$offerSeriesIndex}}" class="collapse" aria-labelledby="headingOfferSeriesOnly" data-parent="#accordionExampleOfferSeriesOnly">
                                                                                    <div class="card-body">
                                                                                        <ul>
                                                                                            @foreach(getPurchasedLessionUnderSeries($purchaseSeries) as $lessionIndex => $lession)
                                                                                                @php $lessionData = $lession->product_series_lession_all; @endphp
                                                                                                <li>Lession : {{$lessionData->title}}
                                                                                                    <span>
                                                                                                        <div class="play-controller">
                                                                                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="previewVideo({{$lessionData->id}}, '{{asset($lessionData->preview_video)}}', '{{$lessionData->title}}')">Preview <i class="fa fa-play"></i> </a>
                                                                                                            <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="previewVideo({{$lessionData->id}}, '{{asset($lessionData->video)}}', '{{$lessionData->title}}')">Watch <i class="fa fa-play"></i> </a>
                                                                                                        </div>
                                                                                                    </span>
                                                                                                </li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <!-- Series Data -->
                                            @if(count($purchase['series']) > 0)
                                                <div class="accordion" id="accordionExampleSeriesOnly">
                                                    @foreach($purchase['series'] as $seriesIndex => $purchaseSeries)
                                                        @php $productSeries = $purchaseSeries->product_series_all; @endphp
                                                        <div class="card">
                                                            <div class="card-header" id="headingTwo">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseSeries{{$seriesIndex}}" aria-expanded="true" aria-controls="collapseOne">Series : {{$productSeries->title}}</button>
                                                                </h2>
                                                            </div>
                                                            <div id="collapseSeries{{$seriesIndex}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExampleSeriesOnly">
                                                                <div class="card-body">
                                                                    <ul>
                                                                        @foreach(getPurchasedLessionUnderSeries($purchaseSeries) as $lessionIndex => $lession)
                                                                            @php $lessionData = $lession->product_series_lession_all; @endphp
                                                                            <li>Lession : {{$lessionData->title}}
                                                                                <span>
                                                                                    <div class="play-controller">
                                                                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="previewVideo({{$lessionData->id}}, '{{asset($lessionData->preview_video)}}', '{{$lessionData->title}}')">Preview <i class="fa fa-play"></i> </a>
                                                                                        <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="previewVideo({{$lessionData->id}}, '{{asset($lessionData->video)}}', '{{$lessionData->title}}')">Watch <i class="fa fa-play"></i> </a>
                                                                                    </div>
                                                                                </span>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <!-- Lession Data -->
                                            @if(count($purchase['lession']) > 0)
                                                <ul>
                                                    @foreach($purchase['lession'] as $lessionIndex => $lession)
                                                        @php $lessionData = $lession->product_series_lession_all; @endphp
                                                        <li>Lession : {{$lessionData->title}}
                                                            <span>
                                                                <div class="play-controller">
                                                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="previewVideo({{$lessionData->id}}, '{{asset($lessionData->preview_video)}}', '{{$lessionData->title}}')">Preview <i class="fa fa-play"></i> </a>
                                                                    <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="previewVideo({{$lessionData->id}}, '{{asset($lessionData->video)}}', '{{$lessionData->title}}')">Watch <i class="fa fa-play"></i> </a>
                                                                    
                                                                </div>
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="float-right">{{ $userPurchase->links() }}</div>
                        
                    @else
                        <div class="text-center">you donot have any history</div>
                    @endif
                    <!-- old Code -->
                    {{-- @foreach($data as $index => $purchase)
                        <div class="card single-purchase-card">
                            <div class="card-body p-0">
                                <div class="purchase-short-history">
                                    <div class="row">
                                        <div class="col-md-3">
                                            @if($purchase['purchase'] == 'offer')
                                                <img src="{{asset($purchase['offer']->image)}}" alt="" class="top-image">
                                            @elseif($purchase['purchase'] == 'series')
                                                <img src="{{asset($purchase['series']->image)}}" alt="" class="top-image">
                                            @elseif($purchase['purchase'] == 'lession')
                                                <img src="{{asset($purchase['lession']->image)}}" alt="" class="top-image">
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <h4 class="card-title purchase-type">{{$purchase['purchase']}}
                                                @if($purchase['purchase'] == 'lession')
                                                    <span>
                                                        <div class="play-controller">
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="previewVideo({{$purchase['lession']->id}}, '{{asset($purchase['lession']->preview_video)}}', '{{$purchase['lession']->title}}')">Preview <i class="fa fa-play"></i> </a>
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="previewVideo({{$purchase['lession']->id}}, '{{asset($purchase['lession']->video)}}', '{{$purchase['lession']->title}}')">Watch <i class="fa fa-play"></i> </a>
                                                        </div>
                                                    </span>
                                                @endif
                                            </h4>
                                            <div class="txn-details">
                                                <table class="table-sm">
                                                    <tr>
                                                        <td colspan="100%">
                                                            <p><span class="title">
                                                                @if($purchase['purchase'] == 'offer')
                                                                    {{$purchase['offer']->title}}
                                                                @elseif($purchase['purchase'] == 'series')
                                                                    {{$purchase['series']->title}}
                                                                @elseif($purchase['purchase'] == 'lession')
                                                                    {{$purchase['lession']->title}}
                                                                @endif
                                                            </span></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><p><span class="title">TXN ID</span></p></td>
                                                        <td><p><span class="text">#{{$purchase['transaction']->transactionId}}</span></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td><p><span class="title">Purchased on</span></p></td>
                                                        <td><p><span class="text">{{date('M d, Y h:i A',strtotime($purchase['transaction']->created_at))}}</span></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td><p><span class="title">Amount</span></p></td>
                                                        <td><p><span class="text">{{currencySymbol($purchase['transaction']->currency)}} {{number_format($purchase['transaction']->amount / 100,2)}}</span></p></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="purchase-list">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-muted m-3 small">You can find your purchase details from here :</p>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="accordion" class="accordion">
                                                @if($purchase['purchase'] == 'offer')
                                                    @foreach($purchase['offer']->series as $offerIndex => $offerSeries)
                                                        <div class="card mb-0 border-0">
                                                            <div class="card-header collapsed" data-toggle="collapse" href="#collapseFaq{{$offerIndex}}">
                                                                <a class="card-title "> {{$offerSeries->product_series_all->title}} </a>
                                                            </div>
                                                            <div id="collapseFaq{{$offerIndex}}" class="card-body collapse @if($offerIndex == 0)show @endif p-0" data-parent="#accordion">
                                                                <div class="p-4 pb-0">
                                                                    <table class="table border-0 table-sm table-hover">
                                                                        @foreach($offerSeries->lession as $lessionIndex => $offerLession)
                                                                            <tr class="single-lesson">
                                                                                <td>
                                                                                    <div class="count">{{$offerLession->productSeriesLessionId}}.</div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="lesson-title">{{$offerLession->product_series_lession_all->title}}</div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="difficulty">{{$offerLession->product_series_lession_all->difficulty}}</div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="play-controller">
                                                                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="previewVideo({{$offerLession->product_series_lession_all->id}}, '{{asset($offerLession->product_series_lession_all->preview_video)}}', '{{$offerLession->product_series_lession_all->title}}')">Preview <i class="fa fa-play"></i> </a>
                                                                                        <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="previewVideo({{$offerLession->product_series_lession_all->id}}, '{{asset($offerLession->product_series_lession_all->video)}}', '{{$offerLession->product_series_lession_all->title}}')">Watch <i class="fa fa-play"></i> </a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @elseif($purchase['purchase'] == 'series')
                                                    <div class="card mb-0 border-0">
                                                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseFaq_series{{$index}}">
                                                            <a class="card-title "> {{$purchase['series']->title}} </a>
                                                        </div>
                                                        <div id="collapseFaq_series{{$index}}" class="card-body collapse @if($index == 0)show @endif p-0" data-parent="#accordion">
                                                            <div class="p-4 pb-0">
                                                                <table class="table border-0 table-sm table-hover">
                                                                    @foreach($purchase['series']->lession as $lessionIndex => $offerLession)
                                                                        <tr class="single-lesson">
                                                                            <td>
                                                                                <div class="count">{{$offerLession->productSeriesLessionId}}.</div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="lesson-title">{{$offerLession->product_series_lession_all->title}}</div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="difficulty">{{$offerLession->product_series_lession_all->difficulty}}</div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="play-controller">
                                                                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="previewVideo({{$offerLession->product_series_lession_all->id}}, '{{asset($offerLession->product_series_lession_all->preview_video)}}', '{{$offerLession->product_series_lession_all->title}}')">Preview <i class="fa fa-play"></i> </a>
                                                                                    <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="previewVideo({{$offerLession->product_series_lession_all->id}}, '{{asset($offerLession->product_series_lession_all->video)}}', '{{$offerLession->product_series_lession_all->title}}')">Watch <i class="fa fa-play"></i> </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach --}}
                    <!-- Old Code End -->
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