@extends('layouts.major')

@section('content')

    <div class="login-main-left">
        <div class="text-center mb-5 login-main-left-header pt-4">
            <h4 class="mt-3 mb-3">Welcome to NINCATI</h4>
        </div>
        <h5 class="modal-header-title" style="margin-bottom: 10px">Login</h5>
        @if($errors->any())
            <div class="alert alert-danger" >
                <h4 style="color: black;font-size: 14px">{{$errors->first()}}</h4>
            </div>
        @endif
        <form method="post" action="{{url('userlogin')}}">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" placeholder="Enter Email" name="email" style="color: white">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control"  placeholder="*******" name="password" style="color: white">
            </div>
            <div class="mt-4">
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-success btn-block btn-lg">Sign In
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="text-center mt-5">
            <p class="light-gray">Don’t have an account? <a style="color: green" href="{{url('user-signup')}}" >Sign Up</a></p>
        </div>
    </div>
@endsection
