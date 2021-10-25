@extends('layouts.auth.authMaster')
@section('title','Dashboard')

@section('content')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Admin Dashboard</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <p class="welcome-text mb-3">Welcome to the Dashboard</p>
                        </div>
                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.master.instrument.list')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Instrument</h5>
                                    <p class="small mb-0">
                                        @foreach ($data->instruments as $key => $instrument)
                                        {{($loop->first ? '' : ', ').($instrument->name)}}
                                        @php
                                            if ($key == 1) {
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
                            <a href="{{route('admin.master.category.list')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Category</h5>
                                    <p class="small mb-0">
                                        @foreach ($data->categories as $category)
                                        {{($loop->first ? '' : ', ') . ($category->name) . ($loop->last ? '...' : '')}}
                                        @endforeach
                                    </p>
                                    <i class="fas fa-list-alt"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.master.genre.list')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Genre</h5>
                                    <p class="small mb-0">
                                        @foreach ($data->genres as $genre)
                                        {{($loop->first ? '' : ', ') . (ucwords($genre->name)) . ($loop->last ? '...' : '')}}
                                        @endforeach
                                    </p>
                                    <i class="fas fa-list"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 dash-card-col">
                            <a href="{{route('admin.users')}}">
                                <div class="card card-body mb-0">
                                    <h5 class="mb-2">Tutors</h5>
                                    <p class="small mb-0">
                                        Tutors' list
                                    </p>
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
                                        <h5 class="mb-2">{{$instrument->name}}</h5>
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
                            <p class="text-muted mb-3">Front</p>
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