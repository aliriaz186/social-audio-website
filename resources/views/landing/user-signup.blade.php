@extends('layouts.major')

@section('content')
    <div style="margin : 0 auto; max-width: 800px;margin-top: 50px;margin-bottom: 200px">
        <div class="text-center mb-5 login-main-left-header pt-4">
            <h4 class="mt-3 mb-3">Welcome to NINCATI</h4>
        </div>
        <h5 class="modal-header-title" style="margin-bottom: 10px;padding: 8px">Sign Up</h5>

        <div class="login-form" style="padding: 10px!important;">
            @if($errors->any())
                <div class="alert alert-danger">
                    <h4 style="color: black;font-size: 14px">{{$errors->first()}}</h4>
                </div>
            @endif
            <form method="post" action="{{url('usersignup')}}">
                @csrf
                <div class="row">

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <input type="text" class="form-control" placeholder="Full Name" name="name" style="color: white">
                                <i class="ti-user"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <input type="email" class="form-control" placeholder="Email" name="email" style="color: white">
                                <i class="ti-email"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <input type="password" class="form-control" placeholder="*******" name="password" style="color: white">
                                <i class="ti-unlock"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="input-with-icon">
                                <input type="text" class="form-control" placeholder="+123 546 5847" name="phone" style="color: white">
                                <i class="lni-phone-handset"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-outline-success full-width pop-login">Sign Up</button>
                </div>

            </form>
                <div class="text-center mt-5">
                    <p class="light-gray">Already have an Account? <a href="{{url('user-login')}}" style="color: #0ac186">Sign In</a></p>
                </div>
        </div>
    </div>

@endsection
