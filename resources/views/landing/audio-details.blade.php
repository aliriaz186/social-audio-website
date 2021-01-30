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
                        <h3>{{$audio->title}}</h3>
                        <p>{{$audio->description ?? ''}}</p>
                        <p>By : <a href="{{url('channel-details')}}/{{$channel->id}}" style="color: white">{{$channel->name ?? ''}}</a></p>
                    </div>
                </div>
                    <div style="margin: 0 auto;max-width: 300px">
                        <div class="video-card">
                            <div class="video-card-image">
                                <a><img src="{{url('/audio-photo')}}/{{$audio->id}}" style="height: 250px" alt=""></a>
                            </div>
                            <div class="video-card-body">

                                <div class="video-view"><i class="fas fa-calendar-alt"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($audio->created_at))->diffForHumans() ?>
                                </div>

                            </div>
                        </div>
                    </div>


            </div>
            <div style="margin: 0 auto;max-width: 300px;margin-top: 10px">
                <audio controls >
                    <source src="{{url('/audio-file')}}/{{$audio->id}}" type="audio/ogg">
                    <source src="{{url('/audio-file')}}/{{$audio->id}}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </div>

        </div>
        @if(empty(\Illuminate\Support\Facades\Session::get('userId')))
        <div style="margin-top: 15px">
            <h5 style="color: white;text-align: center">Please Login to view or post comments</h5>
        </div>
        @else
            <div style="margin-top: 15px">
                @if($audioLiked == true)

                    <div class="dropdown show" style="display: inline!important;">
                        <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            LIKED
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{url('unlike-audio')}}/{{$audio->id}}">Remove From Liked</a>
                        </div>
                    </div>
{{--                    <button class="btn btn-info" style="color: white">LIKED</button>--}}
                @else
                    <a class="btn btn-outline-info" style="color: white" href="{{url('like-audio')}}/{{$audio->id}}">LIKE</a>

                @endif
                    @if($audioSaved == true)
                        <div class="dropdown show" style="display: inline!important;">
                            <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                SAVED
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{url('unsave-audio')}}/{{$audio->id}}">Remove From Saved</a>
                            </div>
                        </div>
                    @else
                        <a class="btn btn-outline-info" style="color: white" href="{{url('save-audio')}}/{{$audio->id}}">SAVE</a>

                    @endif
                <br>
                <br>
                <div style="max-width: 350px;">
                    <form method="post" action="{{url('addcomment')}}">
                        @csrf
                        <h4 style="color: white">Comment</h4><br>
                        <input type="text" class="form-control" name="comment" placeholder="write your comment" style="color: white;max-width: 350px">
                        <input type="hidden" class="form-control" name="audioId" value="{{$audio->id}}">
                        <br>
                        <button class="btn btn-outline-success btn-sm">Comment</button>
                    </form>
                </div>
                <h4 style="color: white;margin-top: 20px">Comments</h4>
                    @if(count($comments) == 0)
                        <h5 style="color: white">No Comment Found!</h5>
                        @endif
                 @foreach($comments as $item)
                <div style="padding: 10px; border: 2px solid white;max-width: 350px;border-radius: 8px;margin-bottom: 5px">
                    <div  style="color: white;font-size: 18px">{{$item->comment}}</div>
                    <div  style="color: white;float: right"><i class="fas fa-user"></i> {{\App\User::where('id', $item->user_id)->first()['name']}} | <i class="fas fa-calendar"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($item->created_at))->diffForHumans() ?></div>
                    <br>
                </div>
                    @endforeach

            </div>
            @endif

    </div>
@endsection
