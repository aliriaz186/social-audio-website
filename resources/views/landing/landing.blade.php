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
            <form action="{{url('search-audio')}}" method="post">
                @csrf
                <div style="margin: 0 auto;max-width: 500px">
                    <input type="text" class="form-control" style="color: white;display: inline!important;" placeholder="type here and hit the ENTER key or Search button" name="audioTitle">
                    <button class="btn btn-outline-success" style="display: inline;margin-top: 10px">SEARCH</button>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="main-title">
                        <h3>Latest Audio</h3>
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
@endsection
