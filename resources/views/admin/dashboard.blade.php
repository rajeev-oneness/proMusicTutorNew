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
                    <div class="row mb-4">
                        @php
                            $month = $price_gbp = $price_usd = $price_euro = [];
                        @endphp
                        <div class="col-12">
                            <canvas id="monthlyReport" height="70"></canvas>
                        </div>
                        <div class="col-12">
                            <table class="table table-sm table-hover">
                                <tr>
                                    <th>Time</th>
                                    <th>GBP</th>
                                    <th>USD</th>
                                    <th>EUR</th>
                                </tr>
                            @php
                                $content = '';

                                foreach($data->salesReport as $reportKey => $reportValue) {
                                    $monthData = date('F Y', strtotime($reportValue->time));

                                    $month[] = $monthData;
                                    $price_gbp[] = $reportValue->price_gbp;
                                    $price_usd[] = $reportValue->price_usd;
                                    $price_euro[] = $reportValue->price_euro;

                                    $content .= '
                                    <tr>
                                        <td>'.$monthData.'</td>
                                        <td>'.$reportValue->price_gbp.'</td>
                                        <td>'.$reportValue->price_usd.'</td>
                                        <td>'.$reportValue->price_euro.'</td>
                                    </tr>
                                    ';
                                }
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
                            <a href="{{route('admin.master.instrument.list')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Instrument ({{count($data->instruments)}})</h5>
                                    <p class="small mb-0">
                                        @foreach ($data->instruments as $key => $instrument)
                                            {{($loop->first ? '' : ', ').($instrument->name)}}
                                            @php if ($key == 2) {echo '...';break;} @endphp
                                        @endforeach
                                    </p>
                                    <i class="fas fa-music"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.master.category.list')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Category ({{count($data->categories)}})</h5>
                                    <p class="small mb-0">
                                        @foreach ($data->categories as $key=> $category)
                                            {{($loop->first ? '' : ', ').($category->name)}}
                                            @php if ($key == 2) {echo '...';break;} @endphp
                                        @endforeach
                                    </p>
                                    <i class="fas fa-list-alt"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.master.genre.list')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Genre ({{count($data->genres)}})</h5>
                                    <p class="small mb-0">
                                        @foreach ($data->genres as $key => $genre)
                                            {{($loop->first ? '' : ', ').($genre->name)}}
                                            @php if ($key == 2) {echo '...';break;} @endphp
                                        @endforeach
                                    </p>
                                    <i class="fas fa-list"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.users')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Tutors ({{count($data->tutors)}})</h5>
                                    <p class="small mb-0">Tutors' list</p>
                                    <i class="fas fa-users"></i>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="row mb-4">
                        @foreach ($data->instruments as $instrument)
                            <div class="col-md-3 dash-card-col">
                                <a href="{{route('admin.product.series.list',[$instrument->id,'instrument='.$instrument->name])}}">
                                    <div class="card card-body mb-0" style="background-image: url({{asset($instrument->image)}})">
                                        <h5 class="mb-2">{{$instrument->name}} ({{count($instrument->product_series)}})</h5>
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
                            <a href="{{route('admin.blog.data.list')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Blogs ({{count($data->blogs)}})</h5>
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.blog.tag.list')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Blog tags ({{count($data->blogTags)}})</h5>
                                    <i class="fas fa-box-open"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.blog.category.list')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Blog Category ({{count($data->blogCategory)}})</h5>
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
                            <a href="{{route('admin.report.transaction')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Sales</h5>
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.report.bestSeller')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Best seller</h5>
                                    <i class="fas fa-box-open"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.report.mostViewed')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Most viewed</h5>
                                    <i class="fas fa-binoculars"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.report.productsOrdered')}}">
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
                            <a href="{{route('admin.testimonial')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Testimonial</h5>
                                    <i class="fas fa-comment-alt"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.faq')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">FAQ</h5>
                                    <i class="fas fa-comment"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.setting.aboutus')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">About us</h5>
                                    <i class="fas fa-user Friends"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.setting.contact')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Contact us</h5>
                                    <i class="fas fa-address-book"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.setting.policy')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Policy</h5>
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.setting.howitWorks')}}">
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
        // monthly report
        var labelValues0 = [];
        var dataValues0 = [];
        var dataValues1 = [];
        var dataValues2 = [];

        labelValues0 = <?php echo json_encode($month); ?>;
        dataValues0 = <?php echo json_encode($price_gbp); ?>;
        dataValues1 = <?php echo json_encode($price_usd); ?>;

        // console.log(dataValues0);

        const ctx0 = document.getElementById('monthlyReport').getContext('2d');
        const monthlyReport = new Chart(ctx0, {
            type: 'line',
            data: {
                labels: labelValues0,
                datasets: [{
                    label: 'State report',
                    datasets: [dataValues0, dataValues1],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // const labels = [
        //     'January',
        //     'February',
        //     'March',
        //     'April',
        //     'May',
        //     'June',
        // ];

        // const data = {
        //     labels: labels,
        //     datasets: [{
        //         label: 'My First dataset',
        //         // backgroundColor: 'rgb(255, 99, 132)',
        //         // borderColor: 'rgb(255, 99, 132)',
        //         data: [0, 10, 5, 2, 20, 30],
        //     }]
        // };

        // const config = {
        //     type: 'line',
        //     data: data,
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             legend: {
        //                 position: 'top',
        //             },
        //             title: {
        //                 display: true,
        //                 // text: 'Chart.js Line Chart'
        //             }
        //         }
        //     },
        // };

        // const myChart = new Chart(document.getElementById('monthlyReport'), config);
    </script>
@endsection