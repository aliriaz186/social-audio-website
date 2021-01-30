<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function accept($id){
       $booking =  Booking::where('id', $id)->first();
        $booking->status = 'accepted';
        $booking->save();
        session()->flash('msg', 'Booking Accepted! You can view customer info now');
        return redirect()->back();
    }

    public function reject($id){
       $booking =  Booking::where('id', $id)->first();
        $booking->status = 'rejected';
        $booking->save();
        session()->flash('msg', 'Booking Rejected!');
        return redirect()->back();
    }

    public function complete($id){
       $booking =  Booking::where('id', $id)->first();
        $booking->status = 'completed';
        $booking->save();
        session()->flash('msg', 'Booking Completed!');
        return redirect()->back();
    }
}
