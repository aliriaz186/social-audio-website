@extends('layouts.customer')
@section('content')
    <div class="px-5">
        <h3>Profile</h3>
        <div class="login-form" style="padding: 30px">
            @if(\Illuminate\Support\Facades\Session::has('msg'))
                <div class="alert alert-success">
                    <h4>{{\Illuminate\Support\Facades\Session::get("msg")}}</h4>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <h4>{{$errors->first()}}</h4>
                </div>
            @endif
            <form method="post" action="{{url('update-customer-registration')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Your Name</label>
                            <input class="form-control" type="text" name="name" value="{{$user->name ?? ''}}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Your Email</label>
                            <input class="form-control" type="text" name="email" value="{{$user->email ?? ''}}" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Your Phone Number</label>
                            <input class="form-control" type="text" name="phone" value="{{$user->phone ?? ''}}">
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 20px">
                    <button type="submit" class="btn btn-primary" style="background: blue; font-size: 15px">Save Info</button>
                </div>

            </form>
        </div>
    </div>
@endsection
