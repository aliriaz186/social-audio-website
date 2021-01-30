@extends('layouts.major')

@section('content')
    @if(\Illuminate\Support\Facades\Session::has('msg'))
        <div class="alert alert-success" style="margin-bottom: 0px!important;">
            <h4>{{\Illuminate\Support\Facades\Session::get("msg")}}</h4>
        </div>
    @endif

    <div class="container-fluid">
        <div class="video-block section-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-title">
                        <h3>Notifications</h3>
                    </div>
                    @if(count($content) == 0)
                    <p style="color: white;font-size: 15px;text-align: center">No Notification Found!</p>
                    @endif
                    @foreach($content as $key => $item)
                    <div style="color: black;padding: 10px;margin-bottom: 10px;font-size: 20px;font-weight: bold;background: white;margin: 0 auto;max-width: 500px">
                       #{{$key + 1}} |  {{$item->user->name}} uploaded new content <a href="{{url('audio-details')}}/{{$item->audio->id}}" style="color: blue;text-decoration: underline">{{$item->audio->title}}</a>
                    </div>
                        <hr>
                    @endforeach

            </div>
        </div>
    </div>
@endsection
