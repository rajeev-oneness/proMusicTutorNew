<div class="dashboard-header">
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        {{-- <a class="navbar-brand" href="{{url('/')}}">{{config('app.name', 'Laravel')}}</a> --}}
        <a class="navbar-brand" href="{{url('/')}}">
            <img src="{{asset('design/img/logopro.png')}}" alt="pro-music-tutor" height="25">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto navbar-right-top">
                @if(Auth::user())
                    <li class="nav-item dropdown nav-user">
                        <a class="nav-link nav-user-img" href="javascript:void(0)" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{asset(Auth::user()->image)}}" alt="" class="user-avatar-md rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                            <div class="nav-user-info">
                                <h5 class="mb-0 text-white nav-user-name">{{ucwords(Auth::user()->name)}} </h5>
                            </div>
                            <a class="dropdown-item" href="{{route('home')}}"><i class="fas fa-user mr-2"></i>Dashboard</a>
                            <a class="dropdown-item" href="{{route('user.profile')}}"><i class="fas fa-cog mr-2"></i>Setting</a>
                            <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-power-off mr-2"></i>{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <div id="custom-search" class="top-search-bar">
                            <a href="{{url('login')}}">Login</a> | <a href="{{url('register')}}">Register</a>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</div>