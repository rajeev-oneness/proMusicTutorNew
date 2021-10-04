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
                    <h5 class="mb-0">Your Purchase Product Series Lession</h5>
                </div>
                <div class="card-body">
                    <div class="card single-purchase-card">
                        <div class="card-body p-0">
                            <div class="purchase-short-history">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img src="http://localhost:8000/design/img/guitar_6.png" alt="" class="top-image">
                                    </div>
                                    <div class="col-md-9">
                                        <h4 class="card-title purchase-type">offer</h4>
                                        <div class="txn-details">
                                            <table class="table-sm">
                                                <tr>
                                                    <td colspan="100%">
                                                        <p>
                                                            <span class="title">Buy Building The Blues Series 1, 2 & 3 by Denny Ilett and receive 25% Discount</span>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>
                                                            <span class="title">TXN ID</span>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p>
                                                            <span class="text">#e8568gny5g8685enkfg53f</span>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>
                                                            <span class="title">Purchased on</span>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p>
                                                            <span class="text">7 Aug, 2021 12:25 PM</span>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>
                                                            <span class="title">Amount</span>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p>
                                                            <span class="text">$ 6788</span>
                                                        </p>
                                                    </td>
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

                                            <div class="card mb-0 border-0">
                                                <div class="card-header collapsed" data-toggle="collapse" href="#collapseFaq1">
                                                    <a class="card-title "> Lorem ipsum dolor, sit amet </a>
                                                </div>
                                                <div id="collapseFaq1" class="card-body collapse show p-0" data-parent="#accordion">
                                                    <div class="p-4 pb-0">

                                                        <table class="table border-0 table-sm table-hover">
                                                            <tr class="single-lesson">
                                                                <td>
                                                                    <div class="count">
                                                                        1.
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="difficulty">
                                                                        easy
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="lesson-title">Series 2 - Lesson 1</div>
                                                                </td>
                                                                <td>
                                                                    <div class="play-controller">
                                                                        <a href="#" class="btn btn-sm btn-primary">Preview <i class="fa fa-play"></i> </a>
                                                                        <a href="#" class="btn btn-sm btn-success">Watch <i class="fa fa-play"></i> </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr class="single-lesson">
                                                                <td>
                                                                    <div class="count">
                                                                        1.
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="difficulty">
                                                                        easy
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="lesson-title">Series 2 - Lesson 1</div>
                                                                </td>
                                                                <td>
                                                                    <div class="play-controller">
                                                                        <a href="#" class="btn btn-sm btn-primary">Preview <i class="fa fa-play"></i> </a>
                                                                        <a href="#" class="btn btn-sm btn-success">Watch <i class="fa fa-play"></i> </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr class="single-lesson">
                                                                <td>
                                                                    <div class="count">
                                                                        1.
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="difficulty">
                                                                        easy
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="lesson-title">Series 2 - Lesson 1</div>
                                                                </td>
                                                                <td>
                                                                    <div class="play-controller">
                                                                        <a href="#" class="btn btn-sm btn-primary">Preview <i class="fa fa-play"></i> </a>
                                                                        <a href="#" class="btn btn-sm btn-success">Watch <i class="fa fa-play"></i> </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr class="single-lesson">
                                                                <td>
                                                                    <div class="count">
                                                                        1.
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="difficulty">
                                                                        easy
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="lesson-title">Series 2 - Lesson 1</div>
                                                                </td>
                                                                <td>
                                                                    <div class="play-controller">
                                                                        <a href="#" class="btn btn-sm btn-primary">Preview <i class="fa fa-play"></i> </a>
                                                                        <a href="#" class="btn btn-sm btn-success">Watch <i class="fa fa-play"></i> </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr class="single-lesson">
                                                                <td>
                                                                    <div class="count">
                                                                        1.
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="difficulty">
                                                                        easy
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="lesson-title">Series 2 - Lesson 1</div>
                                                                </td>
                                                                <td>
                                                                    <div class="play-controller">
                                                                        <a href="#" class="btn btn-sm btn-primary">Preview <i class="fa fa-play"></i> </a>
                                                                        <a href="#" class="btn btn-sm btn-success">Watch <i class="fa fa-play"></i> </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr class="single-lesson">
                                                                <td>
                                                                    <div class="count">
                                                                        1.
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="difficulty">
                                                                        easy
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="lesson-title">Series 2 - Lesson 1</div>
                                                                </td>
                                                                <td>
                                                                    <div class="play-controller">
                                                                        <a href="#" class="btn btn-sm btn-primary">Preview <i class="fa fa-play"></i> </a>
                                                                        <a href="#" class="btn btn-sm btn-success">Watch <i class="fa fa-play"></i> </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-0 border-0">
                                                <div class="card-header collapsed" data-toggle="collapse" href="#collapseFaq2">
                                                    <a class="card-title "> Lorem ipsum dolor, sit amet </a>
                                                </div>
                                                <div id="collapseFaq2" class="card-body collapse p-0" data-parent="#accordion">
                                                    <div class="p-4 pb-0">
                                                        <p class=" mb-0"> Lorem ipsum, dolor sit amet consectetur adipisicing elit. Distinctio exercitationem labore facilis suscipit debitis numquam reiciendis. Optio tenetur necessitatibus nobis commodi assumenda, repellat iste repudiandae quaerat impedit corporis iure sequi. </p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>





                    <div class="table-responsive">
                        <table id="example4" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Instrument</th>
                                	<th>Image</th>
                                    <th>Series</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Purchase On</th>
                                    <th>Transaction Id</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($user->product_purchase_lession as $key => $purchase_lession)
                                    <?php
                                        $lession = $purchase_lession->product_series_lession;
                                        $transaction = $purchase_lession->transaction;
                                        $productSeries = $purchase_lession->product_series;
                                        $category = $productSeries->category;
                                        $instrument = ($category) ? $category->instrument : (object)[];
                                    ?>
                                    <tr>
                                        <td>{{($instrument ? $instrument->name : '')}}</td>
                                        <td><img src="{{asset($lession->image)}}" height="200" width="200"></td>
                                        <td>{{$productSeries->title}}</td>
                                        <td>{{$lession->title}}</td>
                                        <td>£{{$lession->price}}</td>
                                        <td>{!! words($lession->description,100) !!}</td>
                                        <td>{{$purchase_lession->created_at}}</td>
                                        <td>{{$transaction->transactionId}}</td>
                                        <td><a href="{{route('product.series.details',[$lession->productSeriesId, 'autoplayLessonId' => $lession->id,'seriesName' => $productSeries->title, 'lessonName' => $lession->title])}}">View</a></td>
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