<header class="bg-dark-blue">
    <div class="container p-0">
        <nav class="navbar navbar-light navbar-expand-md bg-faded justify-content-center pt-0 pb-0">
            <a href="{{url('/')}}" class="navbar-brand d-flex w-25 mr-auto"><img src="{{asset('design/img/logo.png')}}"></a>
            <div class="navbar-collapse w-100">
                <p class="navbar-nav w-75 justify-content-center d-md-block d-none text-center nav-text">
                    All downloads available in <span>FULL HD </span>or <span>stream</span>
                </p>
                <ul class="nav navbar-nav ml-auto w-100 header-nav">
                    <!-- <li class="nav-item">
                        <a class="nav-link search-icon" href="javascript:void(0)"><img src="{{asset('design/img/search_icon.png')}}"></a>
                    </li> -->
                    <div class="d-flex">
                    @guest
                        @if(Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link signup-bg {{ Route::currentRouteName() == 'register' ? 'bg-orange' : '' }}" href="{{route('register')}}">Sign Up</a>
                            </li>
                        @endif
                        @if(Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link signup-bg login-bg {{ Route::currentRouteName() == 'login' ? 'bg-orange' : '' }}" href="{{route('login')}}"><i class="fas fa-user mr-1"></i> Login</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link signup-bg login-bg {{ Route::currentRouteName() == 'home' ? 'bg-orange' : '' }}" href="{{route('home')}}"><i class="fas fa-user mr-1"></i> Home</a>
                        </li>
                        <li class="nav-item position-relative">
                            <a class="nav-link signup-bg {{ Route::currentRouteName() == 'user.cart.info' ? 'bg-orange' : '' }}" href="{{route('user.cart.info')}}"><img src="{{asset('design/img/cart_icon.png')}}"></a>
                            <div class="cart-count itemCountForCart" id="itemCountForCart">{{count($user->cart_info)}}</div>
                        </li>
                        <li class="nav-item position-relative">
                            <a class="nav-link signup-bg" href="javascript:void(0)" id="noticeSlide"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></a>
                            <div class="badge notice-badge text-white position-absolute notificationCountChangingHeader">{{$notificationAppService->totalNewNotificationCount}}</div>
                            <div class="noticeHidden">
                                <div class="menu-section" style="overflow:scroll;">
                                    <div class="position-fixed py-3 noticeMenuTop">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0)" class="text-white seeAllNotification">See All</a>
                                            <a href="javascript:void(0)" class="text-white markAllAsRead">Mark all as read</a>
                                        </div>
                                    </div>
                                    <ul class="r_menu_ul noticeMenu seeAllNotificationDiv" style="padding:25px 50px">
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
                    </div>
                    <div>
                    <li class="nav-item">
                        <a class="nav-link search-icon" id="slide" href="javascript:void(0)"><img src="{{asset('design/img/menu_icon.png')}}"> <span class="pl-2">Menu</span></a>
                        <div class="hidden">
                            <div class="menu-section">
                                <div class="menulogo mb-5">
                                    <img src="{{asset('design/img/menu-logo.png')}}" class="w-100">
                                </div>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <!-- <li class="nav-item">
                                        <a class="nav-link active border-right" id="guitar-tab" data-toggle="tab" href="#guitar" role="tab" aria-controls="guitar" aria-selected="true">Guitar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link border-right" id="sax-tab" data-toggle="tab" href="#sax" role="tab" aria-controls="sax" aria-selected="false">Sax</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="blog-tab" data-toggle="tab" href="#blog" role="tab" aria-controls="blog" aria-selected="false">Blog</a>
                                    </li> -->
                                </ul>
                                <div class="tab-content pt-4" id="myTabContent">
                                    <div class="tab-pane fade show active" id="guitar" role="tabpanel" aria-labelledby="guitar-tab">
                                        <ul class="r_menu_ul">
                                            <!-- <li><a href="javascript:void(0)">OFFERS</a></li> -->
                                            <li><a href="{{route('browse.product.series')}}">ALL SERIES & PREVIEWS</a></li>
                                            <li><a href="{{route('front.offers')}}">OFFERS</a></li>
                                            <!-- <li><a href="javascript:void(0)">MEET THE PROS</a></li> -->
                                            <li><a href="{{route('howitworks')}}">HOW IT WORKS</a></li>
                                            <li><a class="{{Route::currentRouteName()=='subscription.plan'?'active':''}}" href="{{route('subscription.plan')}}">SUBSCRIPTIONS</a></li>
                                            <li><a class="{{Route::currentRouteName()=='welcome.aboutus'?'active':''}}" href="{{route('welcome.aboutus')}}">About Us</a></li>
                                            @auth
                                            <li><a class="" href="{{route('logout')}}">Logout</a></li>
                                            @endauth
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="sax" role="tabpanel" aria-labelledby="sax-tab">profile tab</div>
                                    <div class="tab-pane fade" id="blog" role="tabpanel" aria-labelledby="blog-tab">contact tab</div>
                                </div>
                                <div class="orange_border"></div>
                            </div>
                        </div>
                    </li>
                    </div>
                </ul>
            </div>
        </nav>
    </div>
</header><!--header-part-->