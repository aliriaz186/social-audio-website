<?php

namespace App\Http\Controllers;

use App\Booking;
use App\professionalprofile;
use App\ProfessionalProfileImage;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Customer extends Controller
{
//    public function bookings(){
//        return view('professional-dashboard.bookings');
//    }

    public function favourites()
    {
        return view('customer-dashboard.favourite');
    }

//    public function chats(){
//        return view('professional-dashboard.chats');
//    }

    public function profile()
    {
        $user = User::where('id', Session::get('userId'))->first();
        return view('customer-dashboard.profile')->with(['user' => $user]);
    }

    public function bookings()
    {
        $this->expireOldBookings();
        $bookings = Booking::where('user_id', Session::get('userId'))->orderBy('id', 'DESC')->get();
        foreach ($bookings as $booking) {
            $booking->professional = professionalprofile::where('id', $booking->professional_id)->first();
            $booking->user = User::where('id', $booking->professional->user_id)->first();
            $booking->images = ProfessionalProfileImage::where('user_id', $booking->user->id)->get();
        }
        return view('customer-dashboard.bookings')->with(['bookings' => $bookings]);
    }

    public function expireOldBookings(){
        $bookings = Booking::where('created_at', '<', Carbon::now()->subDays(2)->toDateTimeString());
        $bookings->where('status', 'pending');
        $bookings = $bookings->get();
        foreach ($bookings as $booking) {
            $booking->status = 'expired';
            $booking->update();
        }
    }
}
