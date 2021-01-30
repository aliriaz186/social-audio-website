<?php

namespace App\Http\Controllers;

use App\Booking;
use App\professionalprofile;
use App\ProfessionalProfileImage;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfessionalController extends Controller
{
    public function bookings(){
        $this->expireOldBookings();
        $professionalId = professionalprofile::where('user_id', Session::get('userId'))->first()['id'];
        $bookings = Booking::where('professional_id', $professionalId)->orderBy('id', 'DESC')->get();
        foreach ($bookings as $booking) {
            $booking->user = User::where('id', $booking->user_id)->first();

//            $fdate = $booking->created_at;
//            $tdate = Carbon::now();
//            $datetime1 = new \DateTime($fdate);
//            $datetime2 = new \DateTime($tdate);
//            date_diff($datetime1, $datetime2);
//            $interval = $datetime1->diff($datetime2);
//            $diffString = "";
//            if ($interval->d > 0){
//                $diffString = $interval->d . " day and " . $interval->h . ' hours remaining';
//            }else{
//                $diffString = $interval->h . ' hours remaining';
//            }
//            $booking->date_diff = $diffString;
        }
        return view('professional-dashboard.bookings')->with(['bookings' => $bookings]);
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

    public function favourites(){
        return view('professional-dashboard.favourites');
    }

    public function chats(){
        return view('professional-dashboard.chats');
    }

    public function profile(){
        $user = User::where('id', Session::get('userId'))->first();
        $user->profile = professionalprofile::where('user_id', $user->id)->first();
        $user->images = ProfessionalProfileImage::where('user_id', $user->id)->get();
        return view('professional-dashboard.profile')->with(['user' => $user]);
    }

    public function searchResult(Request $request){
        $professional = professionalprofile::where('id', '!=' ,0);
        if (!empty($request->serviceType)){
            $professional->where('service_type', $request->serviceType);
        }
        if (!empty($request->area)){
            $professional->where('area', $request->area);
        }
        if (!empty($request->language)){
            $professional->where('language', $request->language);
        }
        if (!empty($request->min)){
            $professional->where('price','>=',intval($request->min));
        }
        if (!empty($request->max)){
            $professional->where('price','<=',intval($request->max));
        }
        $professional = $professional->get();
        foreach ($professional as $item){
            $item->user = User::where('id', $item->user_id)->first();
            $item->images = ProfessionalProfileImage::where('user_id', $item->user_id)->get();
        }
        return view('landing.search-results')->with(['professionals' => $professional, 'filters' => $request]);
    }

    public function bookProfessionalPage($id){
        if (empty(Session::get('userId'))){
            session()->flash('msg', 'Please login before booking any professional. ');
            return redirect()->back();
        }
        $professional = professionalprofile::where('id', '=' ,$id);
        $professional = $professional->first();
        $professional->user = User::where('id', $professional->user_id)->first();
        $professional->images = ProfessionalProfileImage::where('user_id', $professional->user_id)->get();
        return view('landing.book-professional')->with(['professional' => $professional]);
    }

    public function bookProfessional(Request $request){
        if (empty($request->instructions)){
            session()->flash('error', 'Write instructions please');
            return redirect()->back();
        }
        $booking = new Booking();
        $booking->instructions = $request->instructions;
        $booking->user_id = Session::get('userId');
        $booking->professional_id = $request->professional_id;
        $booking->save();
        session()->flash('booked', 'Thanks! Your booking is created.');
        return redirect('');
    }
}
