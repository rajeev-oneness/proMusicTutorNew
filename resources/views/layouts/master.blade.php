<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{config('app.name', 'Pro Music Tutor')}} - @yield('title')</title>
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
    <!-- Header Content -->
    @include('layouts.header')
    
    @yield('content')

    @include('layouts.footer')

    <script type="text/javascript" src="{{asset('design/js/jquery-3.6.0.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('design/js/popper.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('design/js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('design/js/owl.carousel.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('design/js/aos.js')}}"></script>
	<script type="text/javascript" src="{{asset('design/js/custom.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
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
    </script>
    @yield('script')
</body>
</html>