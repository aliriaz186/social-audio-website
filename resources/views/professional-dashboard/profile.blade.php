@extends('layouts.professional')
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
            <form method="post" action="{{url('update-professional-registration')}}" enctype="multipart/form-data">
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

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">What type of services are you providing?</label>
                            <div >
                                <select class="form-control" name="serviceType" >
                                    <option value="">Select Service Type</option>
                                    <option {{$user->profile->service_type == 'Real estate agent'? 'selected' : ''}}>Real estate agent</option>
                                    <option {{$user->profile->service_type == 'Mortgage specialist'? 'selected' : ''}}>Mortgage specialist</option>
                                    <option {{$user->profile->service_type == 'Movers'? 'selected' : ''}}>Movers</option>
                                    <option {{$user->profile->service_type == 'Home stagers'? 'selected' : ''}}>Home stagers</option>
                                    <option {{$user->profile->service_type == 'HVAC'? 'selected' : ''}}>HVAC</option>
                                    <option {{$user->profile->service_type == 'Home inspectors'? 'selected' : ''}}>Home inspectors</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">What is your area of service?</label>
                            <div>
                                <select class="form-control" name="area" >
                                    <option value="">Select Area</option>
                                    @foreach(\App\Places::all() as $place)
                                        <option {{$user->profile->area == $place->place ? 'selected' : ''}}>{{$place->place}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">What is your price in USD?</label>
                            <div >
                                <input type="text" class="form-control" name="price" value="{{$user->profile->price ?? ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">What is your language?</label>
                            <div>
                                <div>
                                    <select class="form-control" name="language">
                                        <option value="">Select Language</option>
                                        <option {{$user->profile->language == 'English'? 'selected' : ''}}>English</option>
                                        <option {{$user->profile->language == 'French'? 'selected' : ''}}>French</option>
                                        <option {{$user->profile->language == 'Turkish'? 'selected' : ''}}>Turkish</option>
                                        <option {{$user->profile->language == 'Hindi'? 'selected' : ''}}>Hindi</option>
                                        <option {{$user->profile->language == 'Urdu'? 'selected' : ''}}>Urdu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Please upload Portfolio images here</label>
                            <div >
                                <input type="file" class="form-control" name="files[]" multiple>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <h3>Your Portfolio Images</h3>--}}
                <div class="row">

                    @foreach($user->images as $image)
                    <div class="col-md-1">
                       <div style="float: right;margin-bottom: 5px">
                           <a class="btn btn-danger btn-sm" href="{{url('/delete-file')}}/{{$image->id}}">X</a>

                       </div>
                        <img src="{{url('/user-file')}}/{{$image->id}}" style="width: 100px!important;height: 100px!important;" alt="" />
                    </div>
                    @endforeach
                </div>

                <div class="form-group" style="margin-top: 20px">
                    <button type="submit" class="btn btn-primary" style="background: blue; font-size: 15px">Save Info</button>
                </div>

            </form>
        </div>
    </div>
@endsection
