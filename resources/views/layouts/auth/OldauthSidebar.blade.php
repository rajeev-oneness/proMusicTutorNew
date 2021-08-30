<div id="mySidenav" class="sidenav">
    <div class="profile-details">
        <div class="pro-image">
            <!-- <img src="{{asset('design/img/profile-image.png')}}" alt=""/> -->
            <img src="{{asset(Auth::user()->image)}}">
        </div>
        <div class="text-center pb-4">
            <h4 class="client-name">{{Auth::user()->name}}</h4>
        </div>
    </div>
    <div class="user-profile">
        <div class="text-center">
            <a class="edit-prof-btn" href="{{route('user.profile')}}"><img src="{{asset('design/img/edit.png')}}">EDIT PROFILE</a>
        </div>
    </div>
    <ul class="linkside">
        <li><a href="{{route('user.points')}}"><img src="{{asset('design/img/edit.png')}}">Your Point</a></li>
        <!-- <li><a href="javascript:void(0)"><img src="{{asset('design/img/event-calender.png')}}">Upload events</a></li> -->
        <!-- <li><a href="javascript:void(0)"><img src="{{asset('design/img/details-upload.png')}}">Upload deals</a></li> -->
        <!-- <li><a href="javascript:void(0)"><img src="{{asset('design/img/like.png')}}">Manage reviews</a></li> -->
    </ul>
    <div class="mt-5">
        <a class="logout-btn" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">LOGOUT</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>