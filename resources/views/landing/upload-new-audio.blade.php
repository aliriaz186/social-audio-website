@extends('layouts.major')

@section('content')
    <div style="margin : 0 auto; max-width: 800px;margin-top: 50px;margin-bottom: 200px">
        <div class="text-center mb-5 login-main-left-header pt-4">
            <h4 class="mt-3 mb-3">Upload Audio</h4>
        </div>
        {{--        <h5 class="modal-header-title" style="margin-bottom: 10px">Sign Up</h5>--}}

        <div class="login-form" style="padding: 10px!important;">
            @if($errors->any())
                <div class="alert alert-danger">
                    <h4 style="color: black;font-size: 14px">{{$errors->first()}}</h4>
                </div>
            @endif
            <form method="post" action="{{url('uploadaudio')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Upload Audio File</label>
                                <input type="file" class="form-control" name="audio[]" required >
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Upload Photo Associated with your Audio File</label>
                                <input type="file" class="form-control" name="audioPhoto[]" required >
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Audio Title</label>
                                <input type="text" class="form-control" placeholder="Audio Title" name="title" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Description</label>
                                <textarea  class="form-control" placeholder="Describe your audio" name="description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Privacy</label>
                                <select class="form-control" name="privacy">
                                    <option selected value="public">Public</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Category</label>
                                <select class="form-control" name="category">
                                    <option selected value="music">Music</option>
                                    <option value="podcasts">Podcasts</option>
                                    <option value="radios">Radios</option>
                                    <option value="playlists">Playlists</option>
                                </select>
                            </div>
                        </div>
                    </div>



                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-outline-success full-width pop-login">Upload</button>
                </div>

            </form>
        </div>
    </div>


@endsection
