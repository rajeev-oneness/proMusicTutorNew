@extends('layouts.auth.authMaster')
@section('title', 'Sales Report')

@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Sales Report</h5>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <button class="headerbuttonforAdd d-block mt-3 my-2" style="float: right; outline: none;"
                                type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
                                aria-controls="collapseExample"><i class="fa fa-filter"></i>Filter</button>

                            <div class="collapse show" id="collapseExample">
                                <div class="card card-body px-0 py-2 border-0 shadow-none">
                                    <form class="form-inline" action="">
                                        {{-- <input type="text" class="form-control form-control-sm mr-2" name="search_tutor"
                                            placeholder="Search tutor" value="{{ $old_search }}"> --}}
                                        <select class="form-control form-control-sm mr-2" name="tutor">
                                            <option value="">--Select tutor--</option>
                                            @foreach ($authors as $a)
                                                <option value="{{ $a }}"
                                                    {{ request()->input('tutor') == $a ? 'selected' : '' }}>
                                                    {{ $a }}</option>
                                            @endforeach
                                        </select>

                                        <select name="seriesId" id="seriesId" class="form-control form-control-sm mr-2"
                                            onchange="filterLesson(this)">
                                            <option value="" hidden selected>--Select series--</option>
                                            @foreach ($available_series as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $req->seriesId ? 'selected' : '' }}>
                                                    {{ $item->title }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <select name="lessionId" id="lessionId" class="form-control form-control-sm mr-2">
                                            <option value="" hidden selected>--Select lesson--</option>
                                            @foreach ($available_lessons as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $req->lessionId ? 'selected' : '' }}>
                                                    {{ $item->title }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <select name="price" id="price" class="form-control form-control-sm mr-2">
                                            <option value="">--Select price filter--</option>
                                            <option value="1" {{ request()->input('price') == 1 ? 'selected' : '' }}>
                                                Price low to high
                                            </option>
                                            <option value="2"
                                                {{ request()->input('price') == 2 ? 'selected' : '' }}>Price high to low
                                            </option>
                                        </select>

                                        @php
                                            $curr_date = date('Y-m-d');
                                            $this_month_first_date = date('Y-m-01');
                                        @endphp

                                        <label for="purchase_from" class="form-label form-label-sm mr-2">Purchase from:
                                        </label>
                                        <input type="date" class="form-control form-control-sm mr-2" name="purchase_from"
                                            id="purchase_from" value="{{ $this_month_first_date }}">

                                        <label for="purchase_to" class="form-label form-label-sm mr-2">Purchase to: </label>
                                        <input type="date" class="form-control form-control-sm mr-2" name="purchase_to"
                                            id="purchase_to" value="{{ $curr_date }}">

                                        <!-- <input type="text" class="form-control form-control-sm mr-2" name="keyword" placeholder="Type something..." value="{{ $req->keyword }}"> -->
                                        <button type="submit" class="btn btn-sm btn-primary mr-2"> <i
                                                class="fa fa-check"></i>
                                            Apply</button>
                                        <a href="{{ route('admin.report.transaction') }}"
                                            class="btn btn-sm btn-secondary"> <i class="fa fa-ban"></i> Remove filters</a>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example5" class="table table-sm table-hover table-striped table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>SR</th>
                                            <th>Order ID</th>
                                            <th>User email</th>
                                            <th>Date of purchase</th>
                                            <th>Lesson/ Series name</th>
                                            <th class="text-right">Amount</th>
                                            <th>Tutor</th>
                                            <th>Sale Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($userPurchase as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->order_id }}</td>
                                                <td>
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <p class="mb-0">{{ $item->customer_name }}</p>
                                                            <p class="text-muted mb-0">{{ $item->customer_email }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ date('j F, Y g:i A', strtotime($item->created_at)) }}
                                                </td>
                                                <td>
                                                    @php
                                                        $lessons = DB::table('user_product_lession_purchases')
                                                            ->where('transactionId', $item->tid)
                                                            ->join('product_series_lessions as l', 'l.id', '=', 'user_product_lession_purchases.productSeriesLessionId')
                                                            ->select('l.title as lesson_name')
                                                            ->get();
                                                        // echo '<pre>';
                                                        // print_r($lessons[0]->lesson_name);
                                                        // exit();
                                                    @endphp
                                                    @foreach ($lessons as $l)
                                                        {{ $l->lesson_name }}<br>
                                                    @endforeach
                                                </td>
                                                <td class="text-right">
                                                    @php
                                                        if ($item->currency == 'usd') {
                                                            $currency = '$';
                                                        } elseif ($item->currency == 'gbp') {
                                                            $currency = '£';
                                                        } else {
                                                            $currency = '€';
                                                        }
                                                    @endphp
                                                    {{ $currency . ' ' . number_format($item->amount) }}
                                                </td>
                                                <td>
                                                    {{ $item->author_name }}
                                                </td>
                                                <td></td>
                                                <td>
                                                    <a href="" class="btn btn-info">Details</a>
                                                    <a href="" class="btn btn-warning"
                                                        style="margin-left: -5px;">Edit</a>
                                                </td>
                                                {{-- <td>{{ strtoupper($item[0]->type_of_product) }}</td>
                                                <td>
                                                    @if ($item[0]->type_of_product == 'offer')
                                                        {{ $item[0]->offer_data->title }}
                                                    @elseif($item[0]->type_of_product == 'series')
                                                        {{ $item[0]->series_data->title }}
                                                    @elseif($item[0]->type_of_product == 'lession')
                                                        {{ $item[0]->lession_data->title }}
                                                    @endif
                                                </td>
                                                <td>{{ $item[0]->order_id }}</td>
                                                <td>{{ currencySymbol($item[0]->currency) }}
                                                    {{ number_format($item[0]->amount / 100, 2) }}</td>
                                                <td>{{ $item[0]->author_details->name }}</td>
                                                <td>{{ date('M d, Y h:i A', strtotime($item[0]->created_at)) }}
                                                </td> --}}
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%" class="text-center text-muted"><em>No record found</em>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="test float-right">
                                    {{ $userPurchase->appends($_GET)->links() }}
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
                    @foreach ($available_series as $series)
                        if (parseInt('{{ $series->createdBy }}') == parseInt(teacher.value)) {
                            options += '<option value="{{ $series->id }}">{{ $series->title }}</option>';
                        }
                    @endforeach
                    $('#seriesId').empty().append(options);
                    $('#lessionId').empty().append('<option value="" hidden selected>Select lession</option>');
                }

                function filterLesson(series) {
                    var options = '<option value="" hidden selected>Select lesson</option>';
                    @foreach ($available_lessons as $lessons)
                        if (parseInt('{{ $lessons->productSeriesId }}') == parseInt(series.value)) {
                            options += '<option value="{{ $lessons->id }}">{{ $lessons->title }}</option>';
                        }
                    @endforeach
                    $('#lessionId').empty().append(options);
                }
            </script>
        @stop
    @endsection
