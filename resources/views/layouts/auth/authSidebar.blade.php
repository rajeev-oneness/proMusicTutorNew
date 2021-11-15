@auth
    @php
        $userType = auth()->user()->user_type;
        $instruments = [];
        if($userType != 3){ // Skipping Student type users
            $instruments = \App\Models\Instrument::get();
        }
    @endphp

    <div class="nav-left-sidebar sidebar-dark">
        <div class="menu-list">
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse pb-4" id="navbarNav">
                    <ul class="navbar-nav flex-column pb-5">
                        <li class="nav-divider"> Menu </li>
                        <li class="nav-item">
                            <a class="nav-link {{request()->routeIs('home')?'active':''}}" href="{{route('home')}}"><i class="fa fa-fw fa-tachometer-alt"></i>Dashboard</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{request()->routeIs('user.profile')?'active':''}}" href="{{route('user.profile')}}"><i class="fa fa-fw fa-id-card"></i>Profile</a>
                        </li>

                        @if($userType == 2) <!-- Tutor Profile Link -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('explore.tutor',[base64_encode($user->id),'tutor' => $user->name])}}"><i class="fa fa-fw fa-user-circle"></i>View Public Profile</a>
                            </li>
                        @endif
                        @if($userType == 3)
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('user.wishlist')?'active':''}}" href="{{route('user.wishlist','0')}}"><i class="fas fa-bookmark"></i>My Favourite</a>
                            </li>
                        @endif

                        @if($userType != 1)
                            <!-- <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('user.points')?'active':''}}" href="{{route('user.points')}}"><i class="fa fa-fw fa-user-circle"></i>Your Points</a>
                            </li> -->
                            @if(count($instruments) > 0)
                                <li class="nav-divider">Products</li>
                                @foreach($instruments as $index => $instru)
                                    <li class="nav-item">
                                        <a class="nav-link {{(request()->is('tutor/instrument/'.$instru->id.'*')) ? 'active' : ''}}" href="{{route('tutor.product.series.list',[$instru->id,'instrument='.$instru->name])}}"><i class="fa fa-fw fa-user-circle"></i>{{$instru->name}}</a>
                                    </li>
                                @endforeach
                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('tutor.offer.*') ? 'active':''}}" href="{{route('tutor.offer.list')}}"><i class="fa-solid fa-percent fa-fw"></i>Offers</a>
                                </li>
                            @endif
                            <!-- Tutor Sidebar -->
                            @if($userType == 2)
                                
                            @endif
                            <li class="nav-divider">Purchase History</li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('user.subscription')?'active':''}}" href="{{route('user.subscription')}}"><i class="fa fa-fw fa-user-circle"></i>Subscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('user.instrument.lession')?'active':''}}" href="{{route('user.instrument.lession')}}"><i class="fa fa-fw fa-user-circle"></i>Order History</a>
                            </li>
                        @endif

                        <!-- Admin Sidebar -->
                        @if($userType == 1)
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.users')?'active':''}}" href="{{route('admin.users')}}"><i class="fas fa-graduation-cap"></i>Tutors</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.users.students')?'active':''}}" href="{{route('admin.users.students')}}"><i class="fas fa-graduation-cap"></i> Students</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.blog.category.*')?'active':''}}" href="{{route('admin.blog.category.list')}}"><i class="fa fa-fw fa-user-circle"></i>Blog Category</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.blog.tag.*')?'active':''}}" href="{{route('admin.blog.tag.list')}}"><i class="fa fa-fw fa-user-circle"></i>Blog Tags</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.blog.data.*')?'active':''}}" href="{{route('admin.blog.data.list')}}"><i class="fa fa-fw fa-user-circle"></i>Blogs</a>
                            </li>

                            @if(count($instruments) > 0)
                                <li class="nav-divider">Products</li>
                                @foreach($instruments as $index => $instru)
                                    <li class="nav-item">
                                        <a class="nav-link {{(request()->is('admin/instrument/'.$instru->id.'*')) ? 'active' : ''}}" href="{{route('admin.product.series.list',[$instru->id,'instrument='.$instru->name])}}"><i class="fa fa-fw fa-user-circle"></i>{{$instru->name}}</a>
                                    </li>
                                @endforeach
                                <li class="nav-item">
                                    <a class="nav-link {{request()->routeIs('admin.offer.*') ? 'active':''}}" href="{{route('admin.offer.list')}}"><i class="fa-solid fa-percent fa-fw"></i>Offers</a>
                                </li>
                            @endif

                            <!-- Report Section -->
                            <li class="nav-divider">Report</li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.report.transaction')?'active':''}}" href="{{route('admin.report.transaction')}}"><i class="fa fa-fw fa-user-circle"></i>Sales</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.report.bestSeller')?'active':''}}" href="{{route('admin.report.bestSeller')}}"><i class="fa fa-fw fa-user-circle"></i>Best seller</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.report.mostViewed')?'active':''}}" href="{{route('admin.report.mostViewed')}}"><i class="fa fa-fw fa-user-circle"></i>Most viewed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.report.productsOrdered')?'active':''}}" href="{{route('admin.report.productsOrdered')}}"><i class="fa fa-fw fa-user-circle"></i>Products ordered</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.report.wishlistReport')?'active':''}}" href="{{route('admin.report.wishlistReport')}}"><i class="fas fa-bookmark"></i>Wishlist</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.report.contactus')?'active':''}}" href="{{route('admin.report.contactus')}}"><i class="fa fa-fw fa-user-circle"></i>Contact us</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.report.user.notification')?'active':''}}" href="{{route('admin.report.user.notification')}}"><i class="fas fa-bell-slash"></i>Notification</a>
                            </li>

                            <li class="nav-divider">Setting</li>
                            <li class="nav-item">
                                <a class="nav-link {{(request()->is('admin/master/*')) ? 'active' : ''}}" href="javascript:void(0)" data-toggle="collapse" aria-expanded="{{request()->routeIs('admin.master.*')?'true':'false'}}" data-target="#submenu-1" aria-controls="submenu-1"><i class="fas fa-fw fa-file"></i>Master Data</a>
                                <div id="submenu-1" class="collapse submenu {{request()->routeIs('admin.master.*')?'show':''}}">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->routeIs('admin.master.instrument.*')?'active':''}}" href="{{route('admin.master.instrument.list')}}"><i class="fa fa-fw fa-user-circle"></i>Instrument</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->routeIs('admin.master.category.*')?'active':''}}" href="{{route('admin.master.category.list')}}"><i class="fa fa-fw fa-user-circle"></i>Category</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->routeIs('admin.master.genre.*')?'active':''}}" href="{{route('admin.master.genre.list')}}"><i class="fa fa-fw fa-user-circle"></i>Genre</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->routeIs('admin.master.subscription.*')?'active':''}}" href="{{route('admin.master.subscription.list')}}"><i class="fa fa-fw fa-user-circle"></i>Subscription</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.testimonial')?'active':''}}" href="{{route('admin.testimonial')}}"><i class="fa fa-fw fa-user-circle"></i>Testimonial</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->routeIs('admin.faq')?'active':''}}" href="{{route('admin.faq')}}"><i class="fa fa-fw fa-user-circle"></i>Faq</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{(request()->is('admin/setting/*')) ? 'active' : ''}}" href="javascript:void(0)" data-toggle="collapse" aria-expanded="{{request()->routeIs('admin.setting.*')?'true':'false'}}" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-fw fa-file"></i>Front Settings </a>
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
                                            <a class="nav-link {{request()->routeIs('admin.setting.howitWork*')?'active':''}}" href="{{route('admin.setting.howitWorks')}}"><i class="fa fa-fw fa-user-circle"></i>How It Works</a>
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