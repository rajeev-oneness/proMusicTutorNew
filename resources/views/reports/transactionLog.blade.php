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

                            <button class="headerbuttonforAdd d-block mt-3 my-2 mr-2" style="float: right; outline: none;"
                                type="button" onclick="htmlToCSV()"><i class="fas fa-check"></i> Export filtered data as
                                CSV</button>

                            <button class="headerbuttonforAdd d-block mt-3 my-2 mr-2" style="float: right; outline: none;"
                                type="button" id="export_all"> Export all
                                data</button>

                            <div class="collapse show" id="collapseExample">
                                <div class="card card-body px-0 py-2 border-0 shadow-none">
                                    <form class="form-inline" action="">
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
                                            id="purchase_from"
                                            value="{{ !empty(request()->input('purchase_from')) ? request()->input('purchase_from') : $this_month_first_date }}">

                                        <label for="purchase_to" class="form-label form-label-sm mr-2">Purchase to: </label>
                                        <input type="date" class="form-control form-control-sm mr-2" name="purchase_to"
                                            id="purchase_to"
                                            value="{{ !empty(request()->input('purchase_to')) ? request()->input('purchase_to') : $curr_date }}">
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
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->order_id }}</td>
                                                <td>
                                                    <div class="media">
                                                        <div class="media-body">
                                                            {{-- <p class="mb-0">{{ $item->customer_name }}</p>
                                                            <p class="text-muted mb-0">{{ $item->customer_email }}
                                                            </p> --}}
                                                            {{ $item->customer_name }}<br>{{ $item->customer_email }}
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
                                                    {{ $currency . ' ' . number_format($item->amount / 100) }}
                                                </td>
                                                <td>
                                                    {{ $item->author_name }}
                                                </td>
                                                <td></td>
                                                <td>
                                                    <a href="{{ route('admin.report.transaction.details', $item->tid) }}"
                                                        class="btn btn-info">Details</a>
                                                    {{-- <a href="" class="btn btn-warning"
                                                        style="margin-left: -5px;">Edit</a> --}}
                                                </td>
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

            <script>
                $('#export_all').click(function() {
                    window.location.href = "http://127.0.0.1:8000/admin/report/sales/log?export_all=true"
                });

                function htmlToCSV() {
                    var data = [];
                    var rows = document.querySelectorAll("#example5 tbody tr");
                    @php
                        if (!request()->input('page')) {
                            $page = '1';
                        } else {
                            $page = request()->input('page');
                        }
                    @endphp

                    var page = "{{ $page }}";

                    data.push("SR NO.,Order ID,User Email,Date of purchase,Lesson/ Series name,Amount,Tutor");

                    for (var i = 0; i < rows.length; i++) {
                        var row = [],
                            cols = rows[i].querySelectorAll("td");

                        for (var j = 0; j < cols.length - 1; j++) {
                            var text = cols[j].innerText.split(',');
                            var new_text = text.join('-');
                            if (j == 2)
                                var comtext = new_text.replace(/\n/g, "-");
                            else
                                var comtext = new_text.replace(/\n/g, ";");
                            row.push(comtext);
                        }
                        data.push(row.join(","));
                    }

                    downloadCSVFile(data.join("\n"), 'SalesReport_page_' + page + '.csv');
                }

                function downloadCSVFile(csv, filename) {
                    var csv_file, download_link;

                    csv_file = new Blob([csv], {
                        type: "text/csv"
                    });

                    download_link = document.createElement("a");

                    download_link.download = filename;

                    download_link.href = window.URL.createObjectURL(csv_file);

                    download_link.style.display = "none";

                    document.body.appendChild(download_link);

                    download_link.click();
                }
            </script>
            @if (request()->input('export_all') == true)
                <script>
                    htmlToCSV();
                    window.location.href = "{{ route('admin.report.transaction') }}";
                </script>
            @endif
        @stop
    @endsection
