@extends('layouts.major')

@section('content')
    <div style="margin : 0 auto; max-width: 800px;margin-top: 50px;margin-bottom: 200px">
        <div class="text-center mb-5 login-main-left-header pt-4">
            <h4 class="mt-3 mb-3">Edit Channel</h4>
        </div>
        {{--        <h5 class="modal-header-title" style="margin-bottom: 10px">Sign Up</h5>--}}

        <div class="login-form">
            @if($errors->any())
                <div class="alert alert-danger">
                    <h4 style="color: black;font-size: 14px">{{$errors->first()}}</h4>
                </div>
            @endif
            <form method="post" action="{{url('editchannelbackend')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Name</label>
                                <input value="{{$channel->name}}" type="text" class="form-control" placeholder="Channel Name" name="name" required style="color: white">
                                <input value="{{$channel->id}}" type="hidden" class="form-control" name="channelId">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Description</label>
                                <textarea  class="form-control" placeholder="Describe your channel" name="description" style="color: white">{{$channel->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <label>Change Profile Photo</label>
                                <input type="file" class="form-control" name="profile[]">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-outline-success full-width pop-login">UPDATE</button>
                </div>

            </form>
        </div>
    </div>


@endsection
