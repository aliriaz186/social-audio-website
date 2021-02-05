@extends('layouts.major')

@section('content')

    <div class="login-main-left">
        <div class="text-center mb-5 login-main-left-header pt-4">
            <h4 class="mt-3 mb-3">Welcome to nincati</h4>
        </div>
        <h5 class="modal-header-title" style="margin-bottom: 10px">Change Password</h5>
        @if($errors->any())
            <div class="alert alert-danger" >
                <h4 style="color: black;font-size: 14px">{{$errors->first()}}</h4>
            </div>
        @endif
        @if(\Illuminate\Support\Facades\Session::has('msg'))
            <div class="alert alert-success" style="margin-bottom: 0px!important;">
                <h4 style="color: black">{{\Illuminate\Support\Facades\Session::get("msg")}}</h4>
            </div>
        @endif
        <form method="post" action="{{url('changepassword')}}">
            @csrf
{{--            <div class="form-group">--}}
{{--                <label>Email</label>--}}
                <input type="hidden" class="form-control" placeholder="Enter Email" name="email" value="{{$email ?? ''}}">
{{--            </div>--}}
            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" placeholder="Enter password" name="password">
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" placeholder="Confirm password" name="confirmpassword">
            </div>
            <div class="mt-4">
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-success btn-block btn-lg">CHANGE PASSWORD
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
