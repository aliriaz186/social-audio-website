<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Booking;
use App\Chat;
use App\ChatParent;
use App\Customer;
use App\professionalprofile;
use App\ProfessionalProfileImage;
use App\Staff;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDashboard()
    {
        $totalCustomers = User::where('user_type', 'customer')->count();
        $totalProfessionals = User::where('user_type', 'professional')->count();
        $totalBookings  = Booking::all()->count();
        return view('home')->with(['totalBookings' => $totalBookings,'totalProfessionals' => $totalProfessionals,'totalCustomers' => $totalCustomers]);
    }

    public function clients(){
       $users = User::where('user_type', 'customer')->get();
       return view('admin.clients')->with(['clients' => $users]);
    }

    public function professionals(){
       $users = User::where('user_type', 'professional')->get();
        foreach ($users as $user) {
            $user->professional = professionalprofile::where('user_id', $user->id)->first();
            $user->user = User::where('id', $user->id)->first();
        }
       return view('admin.professionals')->with(['professionals' => $users]);
    }

    public function bookings(){
        $bookings = Booking::orderBy('id', 'DESC')->get();
        foreach ($bookings as $booking) {
            $booking->professional = professionalprofile::where('id', $booking->professional_id)->first();
            $booking->user = User::where('id', $booking->professional->user_id)->first();
            $booking->client = User::where('id', $booking->user_id)->first();
        }
       return view('admin.bookings')->with(['bookings' => $bookings]);
    }
}
