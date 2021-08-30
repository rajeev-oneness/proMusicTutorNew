<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./favicon.ico">
    <title>{{config('app.name', 'Pro Music Tutor')}} - @yield('title')</title>
    <!--CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<link rel="stylesheet" type="text/css" href="{{asset('design/css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('design/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('design/css/owl.theme.default.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('design/css/style.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('design/css/responsive.css')}}">
    @yield('css')
</head>
<body>
    <!-- loader -->
    <div class="loading-data" style="display:block; color: #fff;">Loading&#8230;</div>

    <!-- include Header -->
    @include('layouts.auth.authHeader')
    <div class="cover-admin">
        <!-- include Sidebar -->
        @include('layouts.auth.authSidebar')
        <div id="main">
            <!-- content Goes Here -->
            @yield('content')
        </div>
    </div>


    <script type="text/javascript" src="{{asset('design/js/jquery-3.6.0.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('design/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('design/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('design/js/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('design/js/aos.js')}}"></script>
    <script type="text/javascript" src="{{asset('design/js/custom.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.loading-data').hide();
        });
        
        @if(Session::has('Success'))
            swal('Success','{{Session::get('Success')}}');
        @elseif(Session::has('Errors'))
            swal('Error','{{Session::get('Errors')}}');
        @endif

        function isNumberKey(evt){
            if(evt.charCode >= 48 && evt.charCode <= 57 || evt.charCode <= 43){  
                return true;  
            }  
            return false;  
        }
        function openNav() {
            document.getElementById("mySidenav").style.width = "295px";
            document.getElementById("mySidenav").style.flex = "0 0 295px";
            document.getElementById("mySidenav").classList.remove('smallfont');
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0px";
            document.getElementById("mySidenav").style.flex = "0 0 0px";
            document.getElementById("main").style.marginLeft= "0px";
            document.getElementById("mySidenav").className += " smallfont";
        }

        jQuery(document).ready(function($) {
            $('.opennav').hide();
            $('.closebtn').click(function(){
                $('.closebtn').hide();
                $('.opennav').show();
            });
            $('.opennav').click(function(){
                $('.closebtn').show();
                $('.opennav').hide();
            });
        });
    </script>
    @yield('script')
</body>
</html>
