<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Askbootstrap">
    <meta name="author" content="Askbootstrap">
    <title>nincati</title>

    <link rel="icon" type="image/png" href="{{asset('small.jpg')}}">

    <link href="{{asset('ui/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('ui/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('ui/css/osahan.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('ui/vendor/owl-carousel/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('ui/vendor/owl-carousel/owl.theme.css')}}">
    <style>

        @media only screen and (max-width: 600px) {
            .pc-side-nav{
                display: none!important;
            }
            .footer{
                display: block!important;
            }
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #252a30;
            color: white;
            text-align: center;
            display: none;
        }
    </style>
</head>
<body id="page-top">
<nav class="navbar navbar-expand-lg navbar-light bg-dark sticky-top">
{{--    <button class="btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle">--}}
{{--        <i class="fas fa-bars"></i>--}}
{{--    </button>--}}
    <a href="{{url('/')}}" class="navbar-brand" href="#" style="color: white!important;margin-top: 5px;margin-left: 5px"><img src="{{asset('new-logo.png')}}" style="width: 150px;height: 50px"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

        </ul>
        <form class="form-inline my-2 my-lg-0">
            @if(empty(\Illuminate\Support\Facades\Session::get('userId')))
                <a href="{{url('user-login')}}" class="btn btn-outline-success my-2 my-sm-0" >SIGN IN</a>
            @else

                <a class="nav-link" href="{{url('notifications')}}" style="color: white;font-size: 15px">
                    <i class="fas fa-bell" style="color: white"></i>
                @if(\App\NewContentNotification::where('user_id', \Illuminate\Support\Facades\Session::get('userId'))->where('status', 'unread')->exists())
                      ({{\App\NewContentNotification::where('user_id', \Illuminate\Support\Facades\Session::get('userId'))->where('status', 'unread')->count()}} New)
                @endif
                </a>

                <a class="nav-link" href="{{url('upload-audio')}}" style="color: white;font-size: 15px" >
                    <i class="fas fa-plus-circle fa-fw" style="color: white"></i>
                    Upload Audio
                </a>

                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{\App\User::where('id', \Illuminate\Support\Facades\Session::get('userId'))->first()['name'] ?? 'User'}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{url('my-channel')}}">My Channel</a>
                        <a class="dropdown-item" href="{{url('my-profile')}}">My Profile</a>
                        <a class="dropdown-item" href="{{url('saved-audio')}}">Saved Audio</a>
                        <a class="dropdown-item" href="{{url('user-logout')}}">Logout</a>
                    </div>
                </div>
            @endif
        </form>
    </div>
</nav>


<div id="wrapper">

    <ul class="sidebar navbar-nav pc-side-nav">
        <li class="nav-item {{url()->current() == url('') ? 'active' : ''}}">
            <a class="nav-link" href="{{url('/')}}">
                <i class="fas fa-fw fa-home"></i>
                <span>Home</span>
            </a>
        </li>
        <li class="nav-item {{url()->current() == url('/trendings') ? 'active' : ''}}">
            <a class="nav-link" href="{{url('/trendings')}}">
                <i class="fas fa-fw fa-lightbulb"></i>
                <span>Trending</span>
            </a>
        </li>
        <li class="nav-item {{url()->current() == url('/channels') ? 'active' : ''}}">
            <a class="nav-link"  href="{{url('/channels')}}">
                <i class="fas fa-fw fa-users"></i>
                <span>Browse Channels</span>
            </a>
        </li>
        <li class="nav-item {{url()->current() == url('/my-channel') ? 'active' : ''}}">
            <a class="nav-link" href="{{url('/my-channel')}}">
                <i class="fas fa-fw fa-user-alt"></i>
                <span>My Channel</span>
            </a>
        </li>
        <li class="nav-item {{url()->current() == url('/upload-audio') ? 'active' : ''}}">
            <a class="nav-link"  href="{{url('upload-audio')}}">
                <i class="fas fa-fw fa-cloud-upload-alt"></i>
                <span>Upload Audio</span>
            </a>
        </li>
        <li class="nav-item {{url()->current() == url('/saved-audio') ? 'active' : ''}}">
            <a class="nav-link"  href="{{url('saved-audio')}}">
                <i class="fas fa-fw fa-save"></i>
                <span>Saved Audio</span>
            </a>
        </li>
        <li class="nav-item {{url()->current() == url('/my-profile') ? 'active' : ''}}">
            <a class="nav-link"  href="{{url('my-profile')}}">
                <i class="fas fa-fw fa-user"></i>
                <span>My Profile</span>
            </a>
        </li>
{{--        <li class="nav-item {{url()->current() == url('/broadcasting') ? 'active' : ''}}">--}}
{{--            <a class="nav-link"  href="{{url('broadcasting')}}">--}}
{{--                <i class="fas fa-fw fa-broadcast-tower"></i>--}}
{{--                <span>Broadcasting</span>--}}
{{--            </a>--}}
{{--        </li>--}}
        <li class="nav-item channel-sidebar-list">
            <h6>SUBSCRIPTIONS</h6>
            <ul>
                @if(!empty(\Illuminate\Support\Facades\Session::get('userId')) && \App\SubscibedChannel::where('subscriber_id', \Illuminate\Support\Facades\Session::get('userId'))->exists())
                    <?php
                        $subscribed = \App\SubscibedChannel::where('subscriber_id', \Illuminate\Support\Facades\Session::get('userId'))->get();
                        $channels = [];
                        foreach ($subscribed as $item){
                            array_push($channels, \App\Channel::where('id', $item->channel_id)->first());
                        }
                    ?>
                    @foreach($channels as $channel)
                        <li>
                            <a href="{{url('/channel-details')}}/{{$channel->id}}">
                                <img class="img-fluid" alt="" src="{{url('/user-profile')}}/{{$channel->id}}"> {{$channel->name}}
                            </a>
                        </li>
                    @endforeach
                @else
                            <li style="color: white">
                              No Subscription Found
                            </li>
                @endif
            </ul>
        </li>
    </ul>
    <div id="content-wrapper">
        @yield('content')
    </div>



    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="d-flex">
            <div>
                <a class="nav-link" href="{{url('/')}}" style="color: white;">
                    <i class="fas fa-fw fa-home"></i>
                    <span style="font-size: 12px">Home</span>
                </a>
            </div>
            <div>
                <a class="nav-link" href="{{url('/trendings')}}" style="color: white;">
                    <i class="fas fa-fw fa-lightbulb"></i>
                    <span  style="font-size: 12px">Trending</span>
                </a>
            </div>
            <div>
                <a class="nav-link"  href="{{url('/channels')}}" style="color: white;">
                    <i class="fas fa-fw fa-users"></i>
                    <span  style="font-size: 12px">Channels</span>
                </a>
            </div>
            <div>
                <a class="nav-link" href="{{url('/my-channel')}}" style="color: white;">
                    <i class="fas fa-fw fa-user-alt"></i>
                    <span  style="font-size: 12px">Channel</span>
                </a>
            </div>
            <div>
                <a class="nav-link"  href="{{url('upload-audio')}}" style="color: white;">
                    <i class="fas fa-fw fa-cloud-upload-alt"></i>
                    <span  style="font-size: 12px">Upload</span>
                </a>
            </div>
            {{--            <div>--}}
            {{--                <a class="nav-link"  href="{{url('saved-audio')}}" style="color: white">--}}
            {{--                    <i class="fas fa-fw fa-save"></i>--}}
            {{--                    <span  style="font-size: 12px">Saved</span>--}}
            {{--                </a>--}}
            {{--            </div>--}}
        </div>

    </div>

    <script src="{{asset('ui/vendor/jquery/jquery.min.js')}}" type="256d66aecf50d6d8425f9975-text/javascript"></script>
    <script src="{{asset('ui/vendor/bootstrap/js/bootstrap.bundle.min.js')}}" type="256d66aecf50d6d8425f9975-text/javascript"></script>

    <script src="{{asset('ui/vendor/jquery-easing/jquery.easing.min.js')}}" type="256d66aecf50d6d8425f9975-text/javascript"></script>

    <script src="{{asset('ui/vendor/owl-carousel/owl.carousel.js')}}" type="256d66aecf50d6d8425f9975-text/javascript"></script>

    <script src="{{asset('ui/js/custom.js')}}" type="256d66aecf50d6d8425f9975-text/javascript"></script>
    <script src="{{asset('ui/rocket-loader.min.js')}}"
            data-cf-settings="256d66aecf50d6d8425f9975-|49" defer=""></script>
    <script defer src="{{asset('ui/beacon.min.js')}}"
            data-cf-beacon='{"rayId":"6136d893ae3b1a32","r":1,"version":"2021.1.1","si":10}'></script>
</body>

</html>
