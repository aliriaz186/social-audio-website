@extends('layouts.major')

@section('content')
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

    <div class="container-fluid">
        <div class="video-block section-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-title">
                        <h3>Browse Channels</h3>
                    </div>
                </div>
                @foreach($channels as $channel)
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="video-card">
                            <div class="video-card-image">
                                <a href="{{url('/channel-details')}}/{{$channel->id}}"><img src="{{url('/user-profile')}}/{{$channel->id}}" style="height: 250px" alt=""></a>
                            </div>
                            <div class="video-card-body">
                                <div class="video-title">
                                    <a href="#">{{$channel->name}}</a>
                                </div>
                                <div class="video-view">
                                    &nbsp;<i class="fas fa-calendar-alt"></i>  Joined <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($channel->created_at))->diffForHumans() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
