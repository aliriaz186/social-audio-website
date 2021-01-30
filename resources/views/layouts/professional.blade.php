<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <link href="{{asset('bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/stylesheet.css')}}" rel="stylesheet">
    {{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"--}}
    {{--          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"--}}
    {{--          crossorigin="anonymous">--}}
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/colors.css')}}" rel="stylesheet">


{{--    <script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('bootstrap.min.js')}}"></script>--}}
{{--    <script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('jquery/3.5.1/jquery.min.js')}}"></script>--}}
{{--    <script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('bootstrap.min.js')}}"></script>--}}
{{--    <script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('popper/popper.min.js')}}"></script>--}}
{{--    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>--}}
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/rangeslider.js')}}"></script>
    <script src="{{asset('assets/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('assets/js/slick.js')}}"></script>
    <script src="{{asset('assets/js/slider-bg.js')}}"></script>
    <script src="{{asset('assets/js/lightbox.js')}}"></script>
    <script src="{{asset('assets/js/imagesloaded.js')}}"></script>

    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('assets/js/cl-switch.js')}}"></script>

    {{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>--}}
    <style>
        .ajax-loader {
            visibility: hidden;
            background-color: rgba(255,255,255,0.7);
            position: absolute;
            z-index: +1000000 !important;
            width: 100%;
            height:100%;
        }

        .ajax-loader img {
            position: relative;
            top:50%;
            left:50%;
        }
    </style>
</head>
<body>

<div class="ajax-loader">
    <img src="{{ url('/ajax-loader.gif') }}" class="img-responsive" />
</div>
<div id="app">
    <div class="header header-light head-shadow">
        <div class="container">
            <nav id="navigation" class="navigation navigation-landscape">
                <div class="nav-header">
                    <a class="nav-brand" href="{{url('')}}">
                        <img src="{{asset('')}}/logo.png" style="height: 60px;width: 100px">
                    </a>
                    <div class="nav-toggle"></div>
                </div>
                <div class="nav-menus-wrapper" style="transition-property: none;">
                    <ul class="nav-menu">

                        <li><a href="{{url('')}}">Home</a></li>
                        <li><a href="{{url('aboutus')}}">About Us</a></li>
                        <li><a href="{{url('contactus')}}">Contact Us</a></li>
                    </ul>

                    <ul class="nav-menu nav-menu-social align-to-right">
                        @if(!\Illuminate\Support\Facades\Session::has('userId'))
                            <li>
                                <a href="{{url('user-login')}}">Signin</a>
                            </li>
                            <li><a href="{{url('user-signup')}}">Sign Up</a></li>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::has('userId'))
                            <li>
                                <a href="JavaScript:Void(0);">{{\App\User::where('id', \Illuminate\Support\Facades\Session::get('userId'))->first()['name']}}<span class="submenu-indicator"></span></a>
                                <ul class="nav-dropdown nav-submenu">
                                    @if(\Illuminate\Support\Facades\Session::get('user_type') != 'customer')
                                        <li><a href="{{url('professional-dashboard')}}">Dashboard</a></li>
                                    @else
                                        <li><a href="{{url('customer-dashboard')}}">Dashboard</a></li>
                                    @endif
                                    <li><a href="{{url('user-logout')}}">Logout</a></li>
                                </ul>
                            </li>
                        @endif
                        {{--                        <li class="add-listing theme-bg">--}}
                        {{--                            <a href="submit-property.html">Add Property</a>--}}
                        {{--                        </li>--}}
                    </ul>
                </div>
            </nav>
        </div>
    </div>





    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-brand">
                    <a class="navbar-brand" href="{{ url('/') }}">Married Home</a>
                    <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <div class="sidebar-header">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded"
                             src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
                             alt="User picture">
                    </div>
                    <div class="user-info">
                        {{--                            <span class="user-name">{{\App\User::where('id', \Illuminate\Support\Facades\Auth::user()->id)->first()['name']}}--}}
                        {{--                                <strong>Smith</strong>--}}
                        {{--                            </span>--}}
                        {{--                        <span class="user-name">{{\App\User::where('id', \Illuminate\Support\Facades\Auth::user()->id)->first()['email']}}--}}
                        {{--                                                            <strong>Smith</strong>--}}
                        {{--                            </span>--}}
                    </div>
                </div>

                <!-- sidebar-search  -->
                <div class="sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>General</span>
                        </li>
                        <li class="">
                            <a href="{{url('professional-dashboard')}}">
                                <i class="fa fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('professional-profile')}}">
                                <i class="fa fa-tachometer-alt"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('professional-favourites')}}">
                                <i class="fa fa-users"></i>
                                <span>Favourites</span>
                            </a>
                        </li>
{{--                        @if(\Illuminate\Support\Facades\Session::get('isAdmin') === true)--}}
{{--                            <li class="">--}}
{{--                                <a href="{{env('APP_URL')}}/staff">--}}
{{--                                    <i class="fas fa-user"></i>--}}
{{--                                    <span>Staff</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
                        <li class="">
                            <a href="{{url('professional-bookings')}}/">
                                <i class="fas fa-users"></i>
                                <span>Bookings</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{url('professional-chats')}}/">
                                <i class="fas fa-users"></i>
                                <span>Chat</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-content  -->
        </nav>
        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
        <!-- page-content" -->
    </div>

</div>
<script>
    function logoutUser()
    {
        event.preventDefault();
        document.getElementById('logoutbtn').click();
    }
    jQuery(function ($) {

        $(".sidebar-dropdown > a").click(function () {
            $(".sidebar-submenu").slideUp(200);
            if (
                $(this)
                    .parent()
                    .hasClass("active")
            ) {
                $(".sidebar-dropdown").removeClass("active");
                $(this)
                    .parent()
                    .removeClass("active");
            } else {
                $(".sidebar-dropdown").removeClass("active");
                $(this)
                    .next(".sidebar-submenu")
                    .slideDown(200);
                $(this)
                    .parent()
                    .addClass("active");
            }
        });

        $("#close-sidebar").click(function () {
            $(".page-wrapper").removeClass("toggled");
        });
        $("#show-sidebar").click(function () {
            $(".page-wrapper").addClass("toggled");
        });

    });
</script>
</body>
</html>
