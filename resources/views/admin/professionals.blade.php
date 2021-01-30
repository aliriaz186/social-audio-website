@extends('layouts.app')
@section('content')
    <div class="px-5">
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
            <div style="padding: 10px;">
                <div style="padding: 15px;">
                    <h3>Professionals</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joining Date</th>
                                <th>View More Details</th>
                                {{--                                <th>Actions</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($professionals as $key => $professional)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$professional->name}}</td>
                                    <td>{{$professional->email}}</td>
                                    <td>{{$professional->phone}}</td>
                                    <td>{{$professional->created_at}}</td>
                                    <td><button onclick="showProfessionalDetails(`{{$professional->user->name}}`, `{{$professional->user->email}}`, `{{$professional->professional->area}}`, `{{$professional->professional->service_type}}`, `{{$professional->professional->price}}`, `{{$professional->professional->language}}`)" class="btn btn-primary" data-toggle="modal" data-target="#myModal1" style="background: blue!important;font-size: 14px">View Professional Details</button></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="myModal1">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Professional Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div>
                        <p>Name : <span id="pname"></span></p>
                    </div>
                    <div>
                        <p>Email : <span id="pemail"></span></p>
                    </div>
                    <div>
                        <p>Area : <span id="area"></span></p>
                    </div>
                    <div>
                        <p>Service  : <span id="service"></span></p>
                    </div>
                    <div>
                        <p>Price  : <span id="price"></span></p>
                    </div>
                    <div>
                        <p>Language  : <span id="language"></span></p>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function showProfessionalDetails(name, email, area, service, price, language) {
            document.getElementById('pname').innerText = name;
            document.getElementById('pemail').innerText = email;
            document.getElementById('area').innerText = area;
            document.getElementById('service').innerText = service;
            document.getElementById('price').innerText = price;
            document.getElementById('language').innerText = language;
        }
    </script>
@endsection
