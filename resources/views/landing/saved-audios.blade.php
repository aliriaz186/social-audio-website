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

    @if(!empty($userExists))
            <div class="container-fluid">
                <div class="video-block section-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-title">
                                <h3>Saved Audio</h3>
                            </div>
                        </div>
                        @foreach($audio as $item)
                            <div class="col-xl-3 col-sm-6 mb-3">
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
        <h4 class="text-center" style="margin-top: 50px">OOPS..</h4>
        <h6 class="text-center" style="margin-top: 25px">Please <a href="{{url('user-login')}}" style="color: green">Login</a> to view your saved audio</h6>
    @endif

@endsection
