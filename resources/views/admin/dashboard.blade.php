@extends('layouts.auth.authMaster')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid  dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Dashboard</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            @php
                                $month = $price_gbp = $price_usd = $price_euro = [];
                            @endphp

                            <div class="col-12 my-4">
                                <canvas id="monthlyReport" height="100"></canvas>
                            </div>

                            <h4 class="">Sales report for last 12 months:</h4>

                            <div class="col-12">
                                <table class="table table-sm table-hover">
                                    <tr>
                                        <th>Month</th>
                                        <th class="text-right">USD</th>
                                        <th class="text-right">GBP</th>
                                        <th class="text-right">EUR</th>
                                    </tr>
                                    @php
                                        $content = '';
                                        $monthEURO = [];
                                        $monthUSD = [];
                                        $monthGBP = [];
                                        foreach ($data->salesReport as $reportKey => $reportValue) {
                                            if ($reportValue->currency == 'usd') {
                                                $monthDataforUSD = date('F Y', strtotime($reportValue->time));
                                                $monthUSD[] = $monthDataforUSD;
                                                $price_usd[] = $reportValue->price;
                                            } elseif ($reportValue->currency == 'gbp') {
                                                $monthDataforGBP = date('F Y', strtotime($reportValue->time));
                                                $monthGBP[] = $monthDataforGBP;
                                                $price_gbp[] = $reportValue->price;
                                            } else {
                                                $monthDataforEURO = date('F Y', strtotime($reportValue->time));
                                                $monthEURO[] = $monthDataforEURO;
                                                $price_euro[] = $reportValue->price;
                                            }
                                        }
                                        
                                        $existingMonthsDataCountForUSD = count($price_usd) - 1;
                                        $existingMonthsDataCountForGBP = count($price_gbp) - 1;
                                        $existingMonthsDataCountForEURO = count($price_euro) - 1;
                                        
                                        $pr_price_gbp = [];
                                        $pr_price_usd = [];
                                        $pr_price_euro = [];
                                        
                                        for ($i = 0; $i < 12; $i++) {
                                            $curr_month = date('F Y', strtotime(date('F Y') . ' - ' . $i . ' months'));
                                            $pr_month[$i] = $curr_month;
                                        
                                            //USD
                                            if (in_array($curr_month, $monthUSD)) {
                                                $pr_price_usd[$i] = $price_usd[$existingMonthsDataCountForUSD];
                                                $existingMonthsDataCountForUSD -= 1;
                                            } else {
                                                $pr_price_usd[$i] = 0;
                                            }
                                        
                                            //GBP
                                            if (in_array($curr_month, $monthGBP)) {
                                                $pr_price_gbp[$i] = $price_gbp[$existingMonthsDataCountForGBP];
                                                $existingMonthsDataCountForGBP -= 1;
                                            } else {
                                                $pr_price_gbp[$i] = 0;
                                            }
                                        
                                            //EURO
                                            if (in_array($curr_month, $monthEURO)) {
                                                $pr_price_euro[$i] = $price_euro[$existingMonthsDataCountForEURO];
                                                $existingMonthsDataCountForEURO -= 1;
                                            } else {
                                                $pr_price_euro[$i] = 0;
                                            }
                                        
                                            $content .= '<tr><td>' . $pr_month[$i] . '</td><td class="text-right">$ ' . $pr_price_usd[$i] . '</td><td class="text-right">€ ' . $pr_price_euro[$i] . '</td><td class="text-right">£' . $pr_price_gbp[$i] . '</td></tr>';
                                        }
                                        // echo '<pre>';
                                        // print_r($pr_month);
                                        // echo '--------------------';
                                        // echo '<pre>';
                                        // print_r($pr_price_gbp);
                                        // echo '--------------------';
                                        // echo '<pre>';
                                        // print_r($pr_price_usd);
                                        // echo '--------------------';
                                        // echo '<pre>';
                                        // print_r($pr_price_euro);
                                        // echo '--------------------';
                                        
                                        // exit();
                                    @endphp

                                    {!! $content !!}
                                </table>
                            </div>
                        </div>
                        <div class="row mb-4">
                            {{-- <div class="col-12">
                            <p class="welcome-text mb-3">Welcome to the Dashboard</p>
                        </div> --}}
                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.master.instrument.list') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Instrument ({{ count($data->instruments) }})</h5>
                                        <p class="small mb-0">
                                            @foreach ($data->instruments as $key => $instrument)
                                                {{ ($loop->first ? '' : ', ') . $instrument->name }}
                                                @php
                                                    if ($key == 2) {
                                                        echo '...';
                                                        break;
                                                    }
                                                @endphp
                                            @endforeach
                                        </p>
                                        <i class="fas fa-music"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.master.category.list') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Category ({{ count($data->categories) }})</h5>
                                        <p class="small mb-0">
                                            @foreach ($data->categories as $key => $category)
                                                {{ ($loop->first ? '' : ', ') . $category->name }}
                                                @php
                                                    if ($key == 2) {
                                                        echo '...';
                                                        break;
                                                    }
                                                @endphp
                                            @endforeach
                                        </p>
                                        <i class="fas fa-list-alt"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.master.genre.list') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Genre ({{ count($data->genres) }})</h5>
                                        <p class="small mb-0">
                                            @foreach ($data->genres as $key => $genre)
                                                {{ ($loop->first ? '' : ', ') . $genre->name }}
                                                @php
                                                    if ($key == 2) {
                                                        echo '...';
                                                        break;
                                                    }
                                                @endphp
                                            @endforeach
                                        </p>
                                        <i class="fas fa-list"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.users') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Tutors ({{ count($data->tutors) }})</h5>
                                        <p class="small mb-0">Tutors' list</p>
                                        <i class="fas fa-users"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="row mb-4">
                            @foreach ($data->instruments as $instrument)
                                <div class="col-md-3 dash-card-col">
                                    <a
                                        href="{{ route('admin.product.series.list', [$instrument->id, 'instrument=' . $instrument->name]) }}">
                                        <div class="card card-body mb-0"
                                            style="background-image: url({{ asset($instrument->image) }})">
                                            <h5 class="mb-2">{{ $instrument->name }}
                                                ({{ count($instrument->product_series) }})
                                            </h5>
                                            <p class="small mb-0">
                                                View series' list
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <p class="text-muted mb-3">Blogs</p>
                            </div>
                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.blog.data.list') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Blogs ({{ count($data->blogs) }})</h5>
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.blog.tag.list') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Blog tags ({{ count($data->blogTags) }})</h5>
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.blog.category.list') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Blog Category ({{ count($data->blogCategory) }})</h5>
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <p class="text-muted mb-3">Report</p>
                            </div>
                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.report.transaction') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Sales</h5>
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.report.bestSeller') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Best seller</h5>
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.report.mostViewed') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Most viewed</h5>
                                        <i class="fas fa-binoculars"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.report.productsOrdered') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Ordered Products</h5>
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <p class="text-muted mb-3">Master Data</p>
                            </div>
                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.testimonial') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Testimonial</h5>
                                        <i class="fas fa-comment-alt"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.faq') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">FAQ</h5>
                                        <i class="fas fa-comment"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.setting.aboutus') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">About us</h5>
                                        <i class="fas fa-user Friends"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.setting.contact') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Contact us</h5>
                                        <i class="fas fa-address-book"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.setting.policy') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">Policy</h5>
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 dash-card-col">
                                <a href="{{ route('admin.setting.howitWorks') }}">
                                    <div class="card card-body mb-0">
                                        <h5 class="mb-2">How it works</h5>
                                        <i class="fas fa-check"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var labelValues0 = [];
        var dataValues0 = [];
        var dataValues1 = [];
        var dataValues2 = [];

        labelValues0 = <?php echo json_encode(array_reverse($pr_month)); ?>;
        dataValues0 = <?php echo json_encode(array_reverse($pr_price_gbp)); ?>;
        dataValues1 = <?php echo json_encode(array_reverse($pr_price_usd)); ?>;
        dataValues2 = <?php echo json_encode(array_reverse($pr_price_euro)); ?>;

        const ctx0 = document.getElementById('monthlyReport').getContext('2d');
        const monthlyReport = new Chart(ctx0, {
            type: 'line',
            data: {
                labels: labelValues0,
                datasets: [{
                        label: '$ USD',
                        data: dataValues1,
                        backgroundColor: 'rgba(192, 244, 190, 0.6)',
                        borderColor: 'black',
                        borderWidth: 1,
                        fill: true,
                    },
                    {
                        label: '£ GBP',
                        data: dataValues0,
                        borderWidth: 1,
                        backgroundColor: 'rgba(238, 130, 238, 0.6)',
                        borderColor: 'black',
                        fill: true,
                    },
                    {
                        label: "€ EURO",
                        data: dataValues2,
                        borderWidth: 1,
                        backgroundColor: 'rgba(106, 90, 205, 0.6)',
                        borderColor: 'black',
                        fill: true,
                    }
                ]
            },
        });
    </script>
@endsection
