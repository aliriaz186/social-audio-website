@extends('layouts.professional')
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
                    <h3>Bookings</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Instructions</th>
                                <th>Customer Details</th>
                                <th>Booking Status</th>
                                <th>Booking Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bookings as $key => $booking)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$booking->user->name}}</td>
                                    <td>{{$booking->instructions}}</td>
                                    @if($booking->status == 'pending')
                                        <td style="color: darkred">Please accept the booking to view customer data</td>
                                    @elseif($booking->status == 'expired')
                                        <td style="color: darkred">No Access</td>
                                    @elseif($booking->status == 'rejected')
                                        <td style="color: darkred">No Access</td>
                                    @else
                                        <td><button onclick="showDetails(`{{$booking->user->name}}`, `{{$booking->user->email}}`, `{{$booking->user->phone}}`)" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="background: blue!important;font-size: 14px">View Customer Details</button></td>
                                    @endif
                                    <td>@if($booking->status == 'pending')
                                            <span style="background: purple;padding: 5px;color: white;border-radius: 10px">{{$booking->status ?? ''}}</span>
                                        @elseif($booking->status == 'rejected')
                                            <span style="background: darkred;padding: 5px;color: white;border-radius: 10px">{{$booking->status ?? ''}}</span>
                                        @elseif($booking->status == 'expired')
                                            <span style="background: darkred;padding: 5px;color: white;border-radius: 10px">{{$booking->status ?? ''}}</span>
                                        @elseif($booking->status == 'accepted' || $booking->status == 'completed')
                                            <span style="background: green;padding: 5px;color: white;border-radius: 10px">{{$booking->status ?? ''}}</span>
                                        @endif</td>
                                    <td>{{$booking->created_at ?? ''}} 
                                    </td>
                                    <td>
                                    @if($booking->status == 'pending')
                                            <a href="{{url('booking-accept')}}/{{$booking->id}}" class="btn btn-success" style="color: white!important;font-size: 13px">Accept</a>
                                            <a href="{{url('booking-reject')}}/{{$booking->id}}" class="btn btn-danger ml-2" style="color: white!important;font-size: 13px">Reject</a>
                                    @elseif($booking->status == 'expired')

                                    @elseif($booking->status == 'rejected')
                                    @elseif($booking->status == 'accepted' )
                                            <a href="{{url('booking-complete')}}/{{$booking->id}}" class="btn btn-success" style="color: white!important;font-size: 13px">Complete Booking</a>
                                        @else

                                     @endif

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Customer Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div>
                        <p>Name : <span id="name"></span></p>
                    </div>
                    <div>
                        <p>Email : <span id="email"></span></p>
                    </div>
                    <div>
                        <p>Phone : <span id="phone"></span></p>
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
        function showDetails(name, email, phone) {
            document.getElementById('name').innerText = name;
            document.getElementById('email').innerText = email;
            document.getElementById('phone').innerText = phone;
        }
    </script>
@endsection
