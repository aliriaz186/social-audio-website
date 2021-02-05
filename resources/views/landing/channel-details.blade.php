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
                max-width: 300px;
                margin-top: 5px;
            }
        }
    </style>
    @if(!empty($userExists))
        @if($channelExists == 1)
            <div style="margin-top: 25px">
                <div style="margin: 0 auto;max-width: 350px">
                    <img src="{{url('/user-profile')}}/{{$channel->id}}" style="width: 300px;height: 300px;margin-left: 20px;object-fit: cover;border-radius: 50%">
                    <h3 style="text-align: center;margin-top: 10px">{{$channel->name}}</h3>
                </div>
            </div>
            @if(\Illuminate\Support\Facades\Session::has('msg'))
                <div class="alert alert-success" style="margin: 0 auto;max-width: 350px;">
                    <h4 style="color: black!important;">{{\Illuminate\Support\Facades\Session::get("msg")}}</h4>
                </div>
            @endif
            <div class="upload-btn-resp">
                @if(\App\SubscibedChannel::where('channel_id', $channel->id)->where('subscriber_id', \Illuminate\Support\Facades\Session::get('userId'))->exists())
                    <button class="btn btn-light" disabled>SUBSCRIBED</button>
                    <a class="btn btn-danger" disabled style="margin-left: 5px;color: black" href="{{url('unsubscribe')}}/{{$channel->id}}">UNSUBSCRIBE</a>

                @else
                    <a class="btn btn-outline-success" style="color: black" href="{{url('subscribe')}}/{{$channel->id}}">SUBSCRIBE</a>
                @endif
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
                                <div class="video-card">
                                    <div class="video-card-image">
                                        <a href="{{url('audio-details')}}/{{$item->id}}"><img src="{{url('/audio-photo')}}/{{$item->id}}" style="height: 350px;width: 400px" alt=""></a>
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
            <h4 class="text-center" style="margin-top: 50px">OOPS..</h4>
            <h6 class="text-center" style="margin-top: 25px">Please <a href="{{url('user-login')}}" style="color: green">Login</a> to view this channel</h6>
        @endif
    @else
        <h4 class="text-center" style="margin-top: 50px">OOPS..</h4>
        <h6 class="text-center" style="margin-top: 25px">Please <a href="{{url('user-login')}}" style="color: green">Login</a> to view this channel</h6>
    @endif

@endsection
