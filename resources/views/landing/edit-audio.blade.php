@extends('layouts.major')

@section('content')
    <div style="margin : 0 auto; max-width: 800px;margin-top: 50px;margin-bottom: 200px">
        <div class="text-center mb-5 login-main-left-header pt-4">
            <h4 class="mt-3 mb-3">Edit Audio</h4>
        </div>
        <div class="login-form" style="padding: 10px!important;">
            @if($errors->any())
                <div class="alert alert-danger">
                    <h4 style="color: black;font-size: 14px">{{$errors->first()}}</h4>
                </div>
            @endif
            <form method="post" action="{{url('uploadupdatedaudio')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Change Audio File</label>
                                <input type="file" class="form-control" name="audio[]" style="color: white">
                                <input type="hidden" class="form-control" name="audioId" value="{{$audio->id}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Change Photo Associated with your Audio File</label>
                                <input type="file" class="form-control" name="audioPhoto[]" style="color: white">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Audio Title</label>
                                <input type="text" class="form-control" value="{{$audio->title}}" placeholder="Audio Title" name="title" required style="color: white">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Description</label>
                                <textarea  class="form-control" placeholder="Describe your audio" name="description" style="color: white">{{$audio->description}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Change Privacy</label>
                                <select class="form-control" name="privacy" style="color: white">
                                    <option {{$audio->privacy == 'public' ? 'selected' : ''}} value="public">Public</option>
                                    <option {{$audio->privacy == 'private' ? 'selected' : ''}} value="private">Private</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-success full-width pop-login">Update Audio</button>
                    <a class="btn btn-outline-danger full-width pop-login" style="margin-left: 5px" href="{{url('delete-audio')}}/{{$audio->id}}">Delete Audio</a>
                </div>

            </form>
        </div>
    </div>


@endsection
