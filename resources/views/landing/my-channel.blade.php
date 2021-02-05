@extends('layouts.major')

@section('content')
    <style>
        .upload-btn-resp{
            float: right;margin-right: 10px;
        }
        @media only screen and (max-width: 600px) {
            .upload-btn-resp{
                float: none;
                margin: 0 auto;
                max-width: 200px;
                margin-top: 5px;
            }
        }
    </style>
    @if(\Illuminate\Support\Facades\Session::has('msg'))
        <div class="alert alert-success" style="margin-bottom: 0px!important;">
            <h4>{{\Illuminate\Support\Facades\Session::get("msg")}}</h4>
        </div>
    @endif
    @if(\Illuminate\Support\Facades\Session::has('booked'))
        <div class="alert alert-success" style="margin-bottom: 0px!important;">
            <h4>You booking is created. Please click <a href="{{url('client-bookings')}}"><strong>here</strong></a> to check status</h4>
        </div>
    @endif

{{--    <div>--}}
{{--        <img src="{{asset('cover-default.jpg')}}" style="width: 100%;height: 400px;object-fit: cover">--}}
{{--    </div>--}}
    @if(!empty($userExists))
        @if($channelExists == 1)
            <div style="margin-top: 25px">
                <div style="margin: 0 auto;max-width: 350px">
                    <img src="{{url('/user-profile')}}/{{$channel->id}}" style="width: 270px;height: 270px;margin-left: 20px;object-fit: cover;border-radius: 50%">
                    <h3 style="text-align: center;margin-top: 10px">{{$channel->name}}</h3>
                </div>
            </div>
            <div style="margin: 0 auto;max-width: 200px;text-align: center;margin-bottom: 5px">
                <a class="btn btn-outline-success" href="{{url('edit-channel')}}/{{$channel->id}}">EDIT CHANNEL</a>
            </div>
            <div style="padding: 10px;border-radius: 8px;border: 1px solid white;background: white;font-size: 15px;margin: 0 auto;max-width: 200px;text-align: center">
                My Subscribers : {{$subscribersCount}}
            </div>

            <div class="upload-btn-resp">
                <a class="btn btn-outline-success" href="{{url('upload-audio')}}">UPLOAD NEW AUDIO</a>
            </div>
            <div class="container-fluid">
                <div class="video-block section-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-title">
                                <h3>Audio</h3>
                            </div>
                        </div>
                        @foreach($audio as $item)
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{url('edit-audio')}}/{{$item->id}}" style="color: black;font-weight: bold">Edit</a>
                                <div class="video-card">
                                    <div class="video-card-image">
                                        <a href="{{url('audio-details')}}/{{$item->id}}"><img src="{{url('/audio-photo')}}/{{$item->id}}" style="height: 250px" alt=""></a>
                                    </div>
                                    <div class="video-card-body">
                                        <div class="video-title">
                                            <a href="{{url('audio-details')}}/{{$item->id}}">{{$item->title}}</a>
                                        </div>
                                        <div class="video-view">
                                             &nbsp;<i class="fas fa-calendar-alt"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($item->created_at))->diffForHumans() ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        @else
            <h4 class="text-center" style="margin-top: 50px">OOPS.. You have not created a channel yet!</h4>
            <div style="margin: 0 auto;max-width: 300px">
                <a href="{{url('create-channel')}}" class="btn btn-outline-success" >CREATE CHANNEL</a>
            </div>
        @endif
    @else
        <h4 class="text-center" style="margin-top: 50px">OOPS..</h4>
        <h6 class="text-center" style="margin-top: 25px">Please <a href="{{url('user-login')}}" style="color: green">Login</a> to view your channel</h6>
    @endif

@endsection
