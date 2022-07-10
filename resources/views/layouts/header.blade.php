<header class="bg-dark-blue position">
    <div class="container p-0">
        <nav class="navbar navbar-light navbar-expand-md bg-faded justify-content-center pt-0 pb-0">
            <a href="{{url('/')}}" class="navbar-brand"><img src="{{asset('design/img/logo.png')}}"></a>
            <div class="navbar-collapse w-100">
                <p class="navbar-nav w-75 justify-content-center d-md-block d-none text-center nav-text">
                    All downloads available in <span>FULL HD </span>or <span>stream</span>
                </p>
                <ul class="nav navbar-nav ml-auto w-100 header-nav">
                    @guest
                        @if(Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link signup-bg {{ Route::currentRouteName() == 'register' ? 'bg-orange' : '' }}" href="{{route('register')}}">
                                    <i class="fas fa-user-plus"></i>
                                    Sign Up
                                </a>
                            </li>
                        @endif
                        @if(Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link signup-bg login-bg {{ Route::currentRouteName() == 'login' ? 'bg-orange' : '' }}" href="{{route('login')}}">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link signup-bg login-bg {{ Route::currentRouteName() == 'home' ? 'bg-orange' : '' }}" href="{{route('home')}}">
                                <i class="fas fa-user"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item position-relative">
                            <a class="nav-link signup-bg {{ Route::currentRouteName() == 'user.cart.info' ? 'bg-orange' : '' }}" href="{{route('user.cart.info')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                <span class="cart-count itemCountForCart notice-badge" id="itemCountForCart">
                                    {{count($user->cart_info)}}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item position-relative">
                            <a class="nav-link signup-bg" href="javascript:void(0)" id="noticeSlide">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                <span class="notice-badge">{{$notificationAppService->totalNewNotificationCount}}</span>
                            </a>
                            <div class="hidden" id="noticeHidden">
                                <div class="menu-section">
                                    <div class="noticeMenuTop">
                                        <a href="javascript:void(0)" class="text-white seeAllNotification">See All</a>
                                        <a href="javascript:void(0)" class="text-white markAllAsRead">Mark all as read</a>
                                    </div>
                                    <ul class="r_menu_ul noticeMenu seeAllNotificationDiv" style="padding-right:10px">
                                        @foreach($notificationAppService->limit_notification as $appServiceNotification)
                                            <li>
                                                <div class="card mb-3 notificationListasActiveInactiveHeader @if($appServiceNotification->read == 1){{('bg-secondary')}}@endif">
                                                    <div class="card-body">
                                                        <h4>{{$appServiceNotification->title}}</h4>
                                                        <p>{{$appServiceNotification->message}}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="orange_border"></div>
                                </div>
                            </div>
                        </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link search-icon" id="slide" href="javascript:void(0)"><img src="{{asset('design/img/menu_icon.png')}}"> <span class="pl-2">Menu</span></a>
                        <div class="hidden" id="menuHidden">
                            <div class="menu-section">
                                <div class="nav-side-top">
                                    <a id="closebtn" href="javascript:void(0)">
                                        <i class="fas fa-times fa-2x mb-5 text-white"></i>
                                    </a>
                                    <div class="menulogo">
                                        <img src="{{asset('design/img/menu-logo.png')}}" class="w-100">
                                    </div>
                                </div>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="guitar" role="tabpanel" aria-labelledby="guitar-tab">
                                        <ul class="r_menu_ul">
                                            <li><a href="{{route('browse.guiter.series')}}">GUITAR</a></li>
                                            <li><a href="{{route('browse.sax.series')}}">SAX</a></li>
                                            <li><a href="{{route('front.offers')}}">OFFERS</a></li>
                                            <li><a href="{{route('browse.product.series')}}">ALL SERIES & PREVIEWS</a></li>
                                            <li><a class="{{Route::currentRouteName()=='explore.tutor'?'active':''}}" href="{{route('explore.tutor')}}">Meet the Pros</a></li>
                                            <li><a class="{{Route::currentRouteName()=='subscription.plan'?'active':''}}" href="{{route('subscription.plan')}}">SUBSCRIPTIONS</a></li>
                                            <li><a class="{{Route::currentRouteName()=='welcome.aboutus'?'active':''}}" href="{{route('welcome.aboutus')}}">About Us</a></li>
                                            <li><a href="{{route('howitworks')}}">HOW IT WORKS</a></li>
                                            <li><a href="{{route('welcome.blogs')}}">Blogs</a></li>
                                            @auth
                                                <li><a class="" href="{{route('logout')}}">Logout</a></li>
                                            @endauth
                                        </ul>
                                    </div>
                                    <!-- <div class="tab-pane fade" id="sax" role="tabpanel" aria-labelledby="sax-tab">profile tab</div>
                                    <div class="tab-pane fade" id="blog" role="tabpanel" aria-labelledby="blog-tab">contact tab</div> -->
                                </div>
                                <div class="orange_border"></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>