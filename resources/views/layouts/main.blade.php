<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>The Married Home</title>
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/colors.css')}}" rel="stylesheet">
    <style>
        .link-btn-class{

        }
        .custom-btn-logo{
            background: #CAE7DD;
            color: black;
            font-size: 15px;
            padding: 10px;;
            border-radius: 5px;
            border: 1px #CAE7DD;
            width: 100px;
            cursor: pointer;
        }
        .custom-btn-logo-full-width{
            background: #CAE7DD;
            color: black;
            font-size: 15px;
            padding: 10px;;
            border-radius: 5px;
            border: 1px #CAE7DD;
            /*width: 100px;*/
            cursor: pointer;
        }
        .hover-a{
            background: #CAE7DD!important;
            color: black!important;
            /*padding: 10px;;*/
            /*border-radius: 5px;*/
            /*border: 1px #CAE7DD;*/
            /*cursor: pointer;*/
        }
        .hover-a:hover{
            color: black!important;
        }
    </style>
</head>

<body class="green-skin">

<div id="preloader"><div class="preloader"><span></span><span></span></div></div>


<div id="main-wrapper">

    <div class="header header-light head-shadow">
        <div class="container">
            <nav id="navigation" class="navigation navigation-landscape">
                <div class="nav-header">
                    <a class="nav-brand" href="{{url('')}}">
                       <img src="{{asset('')}}/logo.png" style="height: 80px;width: 200px">
                    </a>
                    <div class="nav-toggle"></div>
                </div>
                <div class="nav-menus-wrapper" style="transition-property: none;margin-top: 20px">
                    <ul class="nav-menu">

                        <li><a href="{{url('')}}">Home</a></li>
                        <li><a href="{{url('aboutus')}}">About Us</a></li>
                        <li><a href="{{url('contactus')}}">Contact Us</a></li>
                    </ul>

                    <ul class="nav-menu nav-menu-social align-to-right">
                        @if(!\Illuminate\Support\Facades\Session::has('userId'))
                        <li>
                            <a href="{{url('user-login')}}">Login</a>
                        </li>
                        <li ><a  style="background: #CAE7DD;color: black;padding: 15px;border-radius: 15px" href="{{url('user-signup')}}">Sign up</a></li>
{{--                        <li><a href="{{url('user-signup')}}">I am professional</a></li>--}}
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
{{--                                <li><a href="#">Profile</a></li>--}}
{{--                                <li><a href="#">Favourites</a></li>--}}
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
    <!-- End Navigation -->
    <div class="clearfix"></div>


    @yield('content')

    <footer class="dark-footer skin-dark-footer">
        <div>
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-4">
                        <div class="footer-widget">
                           <h3 style="color: white">The Married Home</h3>
                            <div class="footer-add">
                                <p>Company Address...</p>
                                <p>+1 246-345-0695</p>
                                <p>info@example.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <div class="footer-widget">
                            <h4 class="widget-title">Navigations</h4>
                            <ul class="footer-menu">
                                <li><a href="{{url('aboutus')}}">About Us</a></li>
                                <li><a href="{{url('contactus')}}">Contact</a></li>
{{--                                <li><a href="blog.html">Blog</a></li>--}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="footer-widget">
                            <h4 class="widget-title">My Account</h4>
                            <ul class="footer-menu">
                                <li><a href="#">My Profile</a></li>
                                <li><a href="#">My account</a></li>
                                <li><a href="#">Favorites</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6 col-md-6">
                        <p class="mb-0">© 2020 Married Home. All Rights Reserved</p>
                    </div>

                    <div class="col-lg-6 col-md-6 text-right">
                        <ul class="footer-bottom-social">
                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                            <li><a href="#"><i class="ti-twitter"></i></a></li>
                            <li><a href="#"><i class="ti-instagram"></i></a></li>
                            <li><a href="#"><i class="ti-linkedin"></i></a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </footer>

    <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>


</div>


{{--<div class="style-switcher">--}}
{{--    <div class="css-trigger"><a href="#"><i class="ti-settings"></i></a></div>--}}
{{--    <div>--}}
{{--        <ul id="themecolors" class="m-t-20">--}}
{{--            <li><a href="javascript:void(0)" data-skin="default-skin" class="default-theme">1</a></li>--}}
{{--            <li><a href="javascript:void(0)" data-skin="red-skin" class="red-theme">2</a></li>--}}
{{--            <li><a href="javascript:void(0)" data-skin="green-skin" class="green-theme">3</a></li>--}}
{{--            <li><a href="javascript:void(0)" data-skin="blue-skin" class="blue-theme">4</a></li>--}}
{{--            <li><a href="javascript:void(0)" data-skin="yellow-skin" class="yellow-theme">5</a></li>--}}
{{--            <li><a href="javascript:void(0)" data-skin="purple-skin" class="purple-theme">6</a></li>--}}
{{--            <li><a href="javascript:void(0)" data-skin="oceangreen-skin" class="oceangreen-theme">7</a></li>--}}
{{--            <li><a href="javascript:void(0)" data-skin="goodgreen-skin" class="goodgreen-theme">8</a></li>--}}
{{--            <li><a href="javascript:void(0)" data-skin="goodred-skin" class="goodred-theme">9</a></li>--}}
{{--            <li><a href="javascript:void(0)" data-skin="blue2-skin" class="blue2-theme">10</a></li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</div>--}}

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
</body>
</html>
