@extends('layouts.auth.authMaster')
@section('title', 'Sales Report')

@section('content')
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card w-100">
                    <div class="card-header w-100 d-flex justify-content-between">
                        <h5 class="mb-0">Edit Order Details</h5>
                        <a href="{{ route('admin.report.transaction') }}" class="btn btn-dark btn-sm"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div>
                                <form action="{{ route('admin.report.transaction.update', $tid) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name" class="form-label">Name</label>
                                        <select name="userId" id="name" class="form-control">
                                            @foreach ($all_user as $item)
                                                <option
                                                    value="{{ $item->id }}"{{ $item->id == $data[0]->userId ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="series" class="form-label">Select Series</label>
                                        <select id="series" class="form-control" onchange="show_lesson(this.value)">
                                            @foreach ($all_series as $item)
                                                <option
                                                    value="{{ $item->id }}"{{ $item->id == $data[0]->productSeriesId ? 'selected' : '' }}>
                                                    {{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="lesson" class="form-label">Select Lesson</label>
                                        <select id="lesson" class="form-control">
                                            @foreach ($lessons as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="lesson" class="form-label">Amount
                                            ({{ $transaction_data->currency }})</label>
                                        <input type="text" class="form-control w-25"
                                            value="{{ $transaction_data->amount }}" readonly>
                                    </div>
                                    <button type="submit" class="btn btn-info">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- <script>
        function show_lesson(id) {
            var lessons = JSON.parse("{{ $lessons }}");
            var result = [];

            for (var i in lessons)
                console.log(i);
        }
    </script> --}}
@endsection
