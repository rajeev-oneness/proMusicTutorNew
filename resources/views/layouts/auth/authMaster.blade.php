<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name', 'Laravel')}} - @yield('title')</title>
    <link rel="icon" href="{{asset('design/img/logo.png')}}" type="image/gif" sizes="any">
    <link rel="stylesheet" type="text/css" href="{{asset('authDesign/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('authDesign/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('authDesign/css/sumoselect.min.css')}}">
    <link rel="stylesheet" href="{{asset('authDesign/vendor/fonts/fontawesome/css/fontawesome-all.css')}}">
    <link rel="stylesheet" href="{{asset('authDesign/vendor/fonts/flag-icon-css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    @yield('css')
</head>
<body>
    <!-- loader -->
    <div class="loading-data" style="display:block; color: #fff;">Loading&#8230;</div>
    <div class="dashboard-main-wrapper">
        <!-- Header Content -->
        @include('layouts.auth.authHeader')
        <!-- Sidebar Content -->
        @include('layouts.auth.authSidebar')
        <div class="dashboard-wrapper" @if(!Auth::user()) style="margin-left : 0px !important;"@endif>
            <!-- Main Content -->
            @yield('content')
        </div>
    </div>
    <form>@csrf</form>

    <!-- Purchased lesson video modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview</h5>
                    <button type="button" class="close videoCloseFromModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center" style="min-height: 200px"></div>
            </div>
        </div>
    </div>
    <!-- Purchased lesson video modal -->

    <script type="text/javascript" src="{{asset('authDesign/js/jquery-3.5.1.js')}}"></script>
    <script type="text/javascript" src="{{asset('authDesign/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('authDesign/js/sweetalert.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('authDesign/js/sumoselect.min.js')}}"></script>
    <script src="{{asset('authDesign/vendor/slimscroll/jquery.slimscroll.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.loading-data').hide();
        });
        @if(Session::has('Success'))
            swal('Success','{{Session::get('Success')}}', 'success');
        @elseif(Session::has('Errors'))
            swal('Error','{{Session::get('Errors')}}', 'error');
        @endif

        function isNumberKey(evt){
            if(evt.charCode >= 48 && evt.charCode <= 57 || evt.charCode <= 43 || evt.charCode == 46){  
                return true;
            }
            return false;
        }
        function currencySymbol($type = ''){
            $view = '$';
            switch ($type) {
                case 'gbp':$view = '£';break;
                case 'usd':$view = '$';break;
                case 'eur':$view = '€';break;
                case 'euro':$view = '€';break;
                default:$view = '$';break;
            }
            return $view;
        }

        $(document).on('click','.videoCloseFromModal',function(){
            $('#videoModal .modal-body').empty();
        });

        // purchased lesson preview video
        function previewVideo(id, path, name) {
            var targetModalId = '#videoModal';
            $(targetModalId).find('.modal-title').text(name);
            if (!path) {
                $(targetModalId).find('.modal-body').html('<h5 class="text-muted">Nothing to display here !</h5>');
            } else {
                $(targetModalId).find('.modal-body').html('<video class="w-100" controls loop controlsList="nodownload"><source src="'+path+'">Sorry, your browser doesn&apos;t support embedded videos.</video>');
            }
            $(targetModalId).modal('show');
        }
    </script>
    @yield('script')
</body>
</html>
