@extends('layouts.auth.authMaster')
@section('title','Lesson')
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
                                                                                                <li>Lesson : {{$lessionData->title}}
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
                                                                            <li>Lesson : {{$lessionData->title}}
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
                                                        <li>Lesson : {{$lessionData->title}}
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