@auth
    <?php $userType = auth()->user()->user_type; ?>
    <div class="nav-left-sidebar sidebar-dark">
        <div class="menu-list">
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-divider"> Menu </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{request()->routeIs('home')?'active':''}}" href="{{route('home')}}"><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{request()->routeIs('user.profile')?'active':''}}" href="{{route('user.profile')}}"><i class="fa fa-fw fa-user-circle"></i>Profile</a>
                        </li>
                        @if($userType != 1)
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('user.points')?'active':''}}" href="{{route('user.points')}}"><i class="fa fa-fw fa-user-circle"></i>Your Points</a>
                            </li>
                            <!-- Tutor Sidebar -->
                            @if($userType == 2)
                                <li class="nav-divider">Features</li>
                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('tutor.guitar.series')?'active':''}}" href="{{route('tutor.guitar.series')}}"><i class="fa fa-fw fa-user-circle"></i>Guitar Series</a>
                                </li>
                            @endif
                            <li class="nav-divider">Purchase History</li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('user.subscription')?'active':''}}" href="{{route('user.subscription')}}"><i class="fa fa-fw fa-user-circle"></i>Subscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('user.guitar')?'active':''}}" href="{{route('user.guitar')}}"><i class="fa fa-fw fa-user-circle"></i>Guitar Lession</a>
                            </li>
                        @endif

                        <!-- Admin Sidebar -->
                        @if($userType == 1)
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.users')?'active':''}}" href="{{route('admin.users')}}"><i class="fa fa-fw fa-user-circle"></i>Users</a>
                            </li>
                            <li class="nav-divider">Products</li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.guitar.series.*')?'active':''}}" href="{{route('admin.guitar.series.view')}}"><i class="fa fa-fw fa-user-circle"></i>Guitar Series</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" aria-expanded="{{request()->routeIs('admin.master.*')?'true':'false'}}" data-target="#submenu-1" aria-controls="submenu-1"><i class="fas fa-fw fa-file"></i>Master </a>
                                <div id="submenu-1" class="collapse submenu {{request()->routeIs('admin.master.*')?'show':''}}">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->routeIs('admin.master.instrument')?'active':''}}" href="{{route('admin.master.instrument')}}"><i class="fa fa-fw fa-user-circle"></i>Instrument</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->routeIs('admin.master.category')?'active':''}}" href="{{route('admin.master.category')}}"><i class="fa fa-fw fa-user-circle"></i>Category</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->routeIs('admin.master.genre')?'active':''}}" href="{{route('admin.master.genre')}}"><i class="fa fa-fw fa-user-circle"></i>Genre</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!-- Report Section -->
                            <li class="nav-divider">Report</li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.report.contactus')?'active':''}}" href="{{route('admin.report.contactus')}}"><i class="fa fa-fw fa-user-circle"></i>Contact us</a>
                            </li>

                            <li class="nav-divider">Setting</li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.testimonial')?'active':''}}" href="{{route('admin.testimonial')}}"><i class="fa fa-fw fa-user-circle"></i>Testimonial</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.faq')?'active':''}}" href="{{route('admin.faq')}}"><i class="fa fa-fw fa-user-circle"></i>Faq</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" aria-expanded="{{request()->routeIs('admin.setting.*')?'true':'false'}}" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-fw fa-file"></i>Front Settings </a>
                                <div id="submenu-6" class="collapse submenu {{request()->routeIs('admin.setting.*')?'show':''}}">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->routeIs('admin.setting.policy')?'active':''}}" href="{{route('admin.setting.policy')}}"><i class="fa fa-fw fa-user-circle"></i>Policy</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->routeIs('admin.setting.contact')?'active':''}}" href="{{route('admin.setting.contact')}}"><i class="fa fa-fw fa-user-circle"></i>Contact Us</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->routeIs('admin.setting.aboutus')?'active':''}}" href="{{route('admin.setting.aboutus')}}"><i class="fa fa-fw fa-user-circle"></i>About Us</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->routeIs('admin.setting.howitWorks')?'active':''}}" href="{{route('admin.setting.howitWorks')}}"><i class="fa fa-fw fa-user-circle"></i>How It Works</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <!-- Admin Sidebar End -->
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </div>
@endauth