<?php
namespace App\Http\Controllers;

use App\Audio;
use App\AudioComment;
use App\Booking;
use App\Channel;
use App\Contactus;
use App\EmailSignup;
use App\Http\Controllers\Controller;
use App\LikedAudio;
use App\NewContentNotification;
use App\professionalprofile;
use App\ProfessionalProfileImage;
use App\SavedAudio;
use App\Staff;
use App\SubscibedChannel;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use services\email_messages\ForgotPasswordMessage;
use services\email_messages\InvitationMessageBody;
use services\email_messages\JobScheduleForCustomerMessage;
use services\email_services\EmailAddress;
use services\email_services\EmailBody;
use services\email_services\EmailMessage;
use services\email_services\EmailSender;
use services\email_services\EmailSubject;
use services\email_services\MailConf;
use services\email_services\PhpMail;
use services\email_services\SendEmailService;

class UserController extends Controller
{

    public function landing(){
        $audio = Audio::where('privacy', 'public')->orderBy('id', 'DESC')->limit(100)->get();
        return view('landing.landing')->with(['audio' => $audio]);
    }

    public function trending(){
        $audio = Audio::where('privacy', 'public')->orderBy('id', 'DESC')->limit(100)->get();
        return view('landing.trending')->with(['audio' => $audio]);
    }

    public function channels(){
        $channels = Channel::all();
        return view('landing.channels')->with(['channels' => $channels]);
    }

    public function get(Request $request)
    {
        $user_id = $request->get("uid", 0);
        $user = User::find($user_id);
        return $user;
    }

    public function login(Request $request){
        try {
            if (User::where(['email' => $request->email, 'password' => md5($request->password)])->exists()) {
                $id = User::where(['email' => $request->email, 'password' => md5($request->password)])->first()['id'];
                Session::put('userId', $id);
                Session::remove('isAdmin');
                return redirect('');
            } else {
                return redirect()->back()->withErrors(['Invalid username or password']);
            }
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['There is server error right now. Please try again later']);
        }

    }

    public function forgotpassword(Request $request){
        try {
            if (User::where(['email' => $request->email])->exists()) {
                $subject = new SendEmailService(new EmailSubject("Forgot Password Email from nincati"));
                $mailTo = new EmailAddress($request->email);
                $invitationMessage = new ForgotPasswordMessage();
                $token = JWT::encode($request->email, 'secret-2021');
                $emailBody = $invitationMessage->invitationMessageBody($token);
                $body = new EmailBody($emailBody);
                $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
                $sendEmail = new EmailSender(new PhpMail(new MailConf("smtp.gmail.com", "admin@dispatch.com", "secret-2021")));
                $result = $sendEmail->send($emailMessage);
                session()->flash('msg', 'Email Sent Successfully!');
                return redirect()->back();
            } else {
                return redirect()->back()->withErrors(['Email not found in our database!']);
            }
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['There is server error right now. Please try again later']);
        }

    }

    public function resetpassword($token){

        try {
            $email = JWT::decode($token, 'secret-2021', array('HS256'));

            if (empty($email)){
                return json_encode("Access Denied");
            }
            return view('landing.change-password')->with(['email' => $email]);
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['There is server error right now. Please try again later']);
        }

    }

    public function signup(Request $request){
        try {
            if (empty($request->name) || empty($request->email) || empty($request->password)){
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
            if (!User::where(['email' => $request->email])->exists()) {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = '+' . $request->countryCode . $request->phone;
                $user->password = md5($request->password);
                $user->save();
                Session::put('userId', $user->id);
                Session::remove('isAdmin');

                $subject = new SendEmailService(new EmailSubject("Your account has been created on nincati"));
                $mailTo = new EmailAddress($user->email);
                $invitationMessage = new InvitationMessageBody();
                $emailBody = $invitationMessage->invitationMessageBody();
                $body = new EmailBody($emailBody);
                $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
                $sendEmail = new EmailSender(new PhpMail(new MailConf("smtp.gmail.com", "admin@dispatch.com", "secret-2021")));
                $result = $sendEmail->send($emailMessage);
                return redirect('');

            } else {
                return redirect()->back()->withErrors(['Email Already Exists']);
            }
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function myProfile(){
        try {
          if (Session::get('userId')){
              $user = User::where('id', Session::get('userId'))->first();
              return view('landing.my-profile')->with(['user' => $user]);
          }else{
              return view('landing.my-profile');
          }
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function updateProfile(Request $request){
        try {
          if (Session::get('userId')){
              $user = User::where('id', Session::get('userId'))->first();
              $user->name = ($request->name);
              $user->phone = $request->phone;
              $user->update();
              session()->flash('msg', 'Profile Updated Successfully!');
              return redirect('my-profile');
          }else{
              return view('landing.my-profile');
          }
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function changepassword(Request $request){
        try {
            if (empty($request->email) || empty($request->password) || ($request->password != $request->confirmpassword)){
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
                $user = User::where('email', $request->email)->first();
                $user->password = md5($request->password);
                $user->update();
                session()->flash('msg', 'Password Changed Successfully!');
                return redirect('user-login');
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function myChannel(){
        $userExists = Session::get('userId');
        if (!empty($userExists)){
            $channelExists = Channel::where('user_id', Session::get('userId'))->exists();
            if ($channelExists == 1){
                $channel = Channel::where('user_id', Session::get('userId'))->first();
                $audio = Audio::where('channel_id', $channel->id)->get();
                $subscribersCount = SubscibedChannel::where('channel_id', $channel->id)->count();
                return view('landing.my-channel')->with(['userExists' => $userExists, 'channelExists' => $channelExists, 'channel' => $channel, 'audio' => $audio, 'subscribersCount' => $subscribersCount]);
            }else{
                return view('landing.my-channel')->with(['userExists' => $userExists, 'channelExists' => $channelExists]);
            }
        }else{
            return view('landing.my-channel')->with(['userExists' => $userExists]);
        }

    }

    public function getsavedAudio(){
        $userExists = Session::get('userId');
        if (!empty($userExists)) {
            $savedAudio = SavedAudio::where('user_id', Session::get('userId'))->get();
            $audio = [];
            foreach ($savedAudio as $item) {
                array_push($audio, Audio::where('id', $item->audio_id)->first());
            }
            return view('landing.saved-audios')->with(['userExists' => $userExists, 'audio' => $audio]);
        } else {
            return view('landing.saved-audios')->with(['userExists' => $userExists]);
        }

    }

    public function addcomment(Request $request){
        $comment = new AudioComment();
        $comment->audio_id = $request->audioId;
        $comment->user_id = Session::get('userId');
        $comment->comment = $request->comment;
        $comment->save();
        return redirect()->back();
    }

    public function channelDetails($id){
        $userExists = Session::get('userId');
        if (!empty($userExists)){
            $channelExists = Channel::where('id', $id)->exists();
            if ($channelExists == 1){
                $channel =Channel::where('id', $id)->first();
                $audio = Audio::where('channel_id', $channel->id)->get();
                return view('landing.channel-details')->with(['userExists' => $userExists, 'channelExists' => $channelExists, 'channel' => $channel, 'audio' => $audio]);
            }else{
                return view('landing.channel-details')->with(['userExists' => $userExists, 'channelExists' => $channelExists]);
            }
        }else{
            return view('landing.channel-details')->with(['userExists' => $userExists]);
        }

    }

    public function subscribe($id){
        $subscribe = new SubscibedChannel();
        $subscribe->channel_id = $id;
        $subscribe->subscriber_id = Session::get('userId');
        $subscribe->save();
        session()->flash('msg', 'Subscribed Successfully!');
        return redirect()->back();
    }

    public function unsubscribe($id){
        $subscribe = SubscibedChannel::where('channel_id', $id)->where('subscriber_id', Session::get('userId'))->first();
        $subscribe->delete();
        session()->flash('msg', 'UnSubscribed Successfully!');
        return redirect()->back();
    }

    public function recordLive(){
       return view('landing.record-live');
    }

    public function unsaveAudio($id){
        $audio = SavedAudio::where('audio_id', $id)->where('user_id', Session::get('userId'))->first();
        $audio->delete();
        return redirect()->back();
    }

    public function unLikedAudio($id){
        $audio = LikedAudio::where('audio_id', $id)->where('user_id', Session::get('userId'))->first();
        $audio->delete();
        return redirect()->back();
    }

    public function createChannel(){
        return view('landing.create-channel');
    }

    public function editChannel($id){
        $channel = Channel::where('id', $id)->first();
        return view('landing.edit-channel')->with(['channel' => $channel]);
    }

    public function editAudio($id){
        $audio = Audio::where('id', $id)->first();
        return view('landing.edit-audio')->with(['audio' => $audio]);
    }

    public function uploadnewAudio(){
        if (empty(Session::get('userId'))){
            return redirect()->back()->withErrors(['Please Login to continue!']);
        }
        return view('landing.upload-new-audio');
    }

    public function notifications(){
        if (empty(Session::get('userId'))){
            return redirect()->back()->withErrors(['Please Login to continue!']);
        }
        $content = NewContentNotification::where('user_id', Session::get('userId'))->orderBy('id', 'DESC')->get();
        foreach ($content as $item){
            $item->status = 'read';
            $item->update();
            $item->audio = Audio::where('id', $item->audio_id)->first();
            $item->user = User::where('id', $item->uploader_id)->first();

        }
        return view('landing.notifications')->with(['content' => $content]);
    }

    public function searchAudio(Request $request){
        $audio = Audio::where('title', 'LIKE', '%' . $request->audioTitle . '%')->where('privacy', 'public')->orderBy('id', 'DESC')->get();
        return view('landing.search-result')->with(['audio' => $audio]);
    }

    public function audioDetails($id){
        $audio = Audio::where('id', $id)->first();
        $user = User::where('id', $audio->user_id)->first();
        $channel = Channel::where('user_id', $user->id)->first();
        $audioLiked = false;
        if (LikedAudio::where('audio_id', $id)->where('user_id', Session::get('userId'))->exists()){
            $audioLiked = true;
        }
        $audioSaved = false;
        if (SavedAudio::where('audio_id', $id)->where('user_id', Session::get('userId'))->exists()){
            $audioSaved = true;
        }
        $comments = AudioComment::where('audio_id', $id)->get();
        return view('landing.audio-details')->with(['audio' => $audio,'user' => $user,'channel' => $channel, 'audioLiked' => $audioLiked, 'audioSaved' => $audioSaved, 'comments' => $comments]);
    }

    public function deleteAudio($id){
        $audio = Audio::where('id', $id)->first();
       $audio->delete();
        return redirect('/my-channel');
    }

    public function likeAudio($audioId){
        $likedAudio = new LikedAudio();
        $likedAudio->user_id = Session::get('userId');
        $likedAudio->audio_id = $audioId;
        $likedAudio->save();
        return redirect()->back();
    }

    public function saveAudio($audioId){
        $savedAudio = new SavedAudio();
        $savedAudio->user_id = Session::get('userId');
        $savedAudio->audio_id = $audioId;
        $savedAudio->save();
        return redirect()->back();
    }

    public function createChannelBackend(Request $request){
        try {
            if (empty($request->name)){
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
            if (!Channel::where(['name' => $request->name])->exists()) {
                $channel = new Channel();
                $channel->name = $request->name;
                $channel->description = $request->description;
                $channel->user_id = Session::get('userId');
                if ($request->hasfile('profile')) {
                    $files = $request->file('profile');
                    foreach ($files as $file){
                        $name = time() . '.' . $file->getClientOriginalExtension();
                        $file->move(base_path('/data') . '/user-files/',  $name);
                        $channel->profile_photo = $name;
                    }
                }else{
                    return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
                }
                $channel->save();
                return redirect('/my-channel');
            } else {
                return redirect()->back()->withErrors(['Channel Name Already Exists']);
            }
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function editchannelbackend(Request $request){
        try {
            if (empty($request->name) && empty($request->channelId)) {
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
            $channel = Channel::where('id', $request->channelId)->first();
            $channel->name = $request->name;
            $channel->description = $request->description;
            if ($request->hasfile('profile')) {
                $files = $request->file('profile');
                foreach ($files as $file) {
                    $name = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(base_path('/data') . '/user-files/', $name);
                    $channel->profile_photo = $name;
                }
            }
            $channel->update();
            return redirect('/my-channel');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function uploadaudio(Request $request){
        try {
            if (empty($request->title) && empty($request->privacy)) {
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
            $audio = new Audio();
            $audio->title = $request->title;
            $audio->description = $request->description;
            $audio->privacy = $request->privacy;
            $audio->category = $request->category;
            $audio->user_id = Session::get('userId');
            $audio->channel_id = Channel::where('user_id', $audio->user_id)->first()['id'];
            if ($request->hasfile('audio')) {
                $files = $request->file('audio');
                foreach ($files as $file) {
                    $name = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(base_path('/data') . '/channel-files/', $name);
                    $audio->audio = $name;
                }
            } else {
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
            if ($request->hasfile('audioPhoto')) {
                $files = $request->file('audioPhoto');
                foreach ($files as $file) {
                    $name = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(base_path('/data') . '/audio-photos/', $name);
                    $audio->audio_photo = $name;
                }
            } else {
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
            $audio->save();
            if ($audio->privacy == 'public'){
                $this->saveNewContentNotification(Session::get('userId'), $audio->id);
            }
            return redirect('/my-channel');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function saveNewContentNotification($uploaderId, $audioId){
        $users = User::all();
        foreach ($users as $user){
            $newContent = new NewContentNotification();
            $newContent->uploader_id = $uploaderId;
            $newContent->user_id = $user->id;
            $newContent->audio_id = $audioId;
            $newContent->save();
        }
    }

    public function uploadupdatedaudio(Request $request){
        try {
            if (empty($request->title) && empty($request->privacy)) {
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
            $audio = Audio::where('id', $request->audioId)->first();
            $audio->title = $request->title;
            $audio->description = $request->description;
            $audio->privacy = $request->privacy;
            $audio->category = $request->category;
            if ($request->hasfile('audio')) {
                $files = $request->file('audio');
                foreach ($files as $file) {
                    $name = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(base_path('/data') . '/channel-files/', $name);
                    $audio->audio = $name;
                }
            }
            if ($request->hasfile('audioPhoto')) {
                $files = $request->file('audioPhoto');
                foreach ($files as $file) {
                    $name = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(base_path('/data') . '/audio-photos/', $name);
                    $audio->audio_photo = $name;
                }
            }
            $audio->update();
            return redirect('/my-channel');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function logout(){
        Session::flush();
        return redirect('');
    }

    public function saveContactus(Request $request){
        try {
            if (empty($request->name) || empty($request->email) || empty($request->subject) || empty($request->message)) {
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
            $contact = new Contactus();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();
            session()->flash('msg', 'Message Sent Successfully!');
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['There is server Error. Please try again later.']);
        }
    }

    public function saveProfessionalRegistration(Request $request){
        try {
            if (empty($request->serviceType) || empty($request->area) || empty($request->price) || empty($request->language)) {
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
            $professionalProfile = new professionalprofile();
            $professionalProfile->service_type = $request->serviceType;
            $professionalProfile->area = $request->area;
            $professionalProfile->price = $request->price;
            $professionalProfile->language = $request->language;
            $professionalProfile->user_id = Session::get('userId');
            $professionalProfile->save();

            if ($request->hasfile('files')) {
                $files = $request->file('files');
                foreach ($files as $file){
                    $name = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(base_path('/data') . '/user-files/',  $name);
                    $professionalImage = new ProfessionalProfileImage();
                    $professionalImage->image = $name;
                    $professionalImage->user_id = Session::get('userId');
                    $professionalImage->save();
                }

            }
            return redirect('');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function updateProfessionalRegistration(Request $request){
        try {
            if (empty($request->serviceType) || empty($request->area) || empty($request->price) || empty($request->language)) {
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
            if (empty($request->name) || empty($request->phone)) {
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
            $user = User::where('id', Session::get('userId'))->first();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->update();
            if (professionalprofile::where('user_id', Session::get('userId'))->exists()){
                $professionalProfile = professionalprofile::where('user_id', Session::get('userId'))->first();
                $professionalProfile->service_type = $request->serviceType;
                $professionalProfile->area = $request->area;
                $professionalProfile->price = $request->price;
                $professionalProfile->language = $request->language;
                $professionalProfile->update();
            }else{
                $professionalProfile = new professionalprofile();
                $professionalProfile->service_type = $request->serviceType;
                $professionalProfile->area = $request->area;
                $professionalProfile->price = $request->price;
                $professionalProfile->language = $request->language;
                $professionalProfile->user_id = Session::get('userId');
                $professionalProfile->save();
            }

            if ($request->hasfile('files')) {
                $files = $request->file('files');
                foreach ($files as $file){
                    $name = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(base_path('/data') . '/user-files/',  $name);
                    $professionalImage = new ProfessionalProfileImage();
                    $professionalImage->image = $name;
                    $professionalImage->user_id = Session::get('userId');
                    $professionalImage->save();
                }

            }
            session()->flash('msg', 'Info Saved Successfully!');
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function updateCustomerRegistration(Request $request){
        try {
            if (empty($request->name) || empty($request->phone)) {
                return redirect()->back()->withErrors(['Invalid Inputs. Please provide valid info.']);
            }
            $user = User::where('id', Session::get('userId'))->first();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->update();
            session()->flash('msg', 'Info Saved Successfully!');
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function userFile($id){
        $img = ProfessionalProfileImage::where('id', $id)->first();
        $file =  base_path('/data') . '/user-files/' . $img->image;
        $type = mime_content_type($file);
        header('Content-Type:' . $type);
        header('Content-Length: ' . filesize($file));
        return readfile($file);
    }

    public function userProfile($id){
        $channel = Channel::where('id', $id)->first();
        $file =  base_path('/data') . '/user-files/' . $channel->profile_photo;
        $type = mime_content_type($file);
        header('Content-Type:' . $type);
        header('Content-Length: ' . filesize($file));
        return readfile($file);
    }

    public function audioPhoto($id){
        $audio = Audio::where('id', $id)->first();
        $file =  base_path('/data') . '/audio-photos/' . $audio->audio_photo;
        $type = mime_content_type($file);
        header('Content-Type:' . $type);
        header('Content-Length: ' . filesize($file));
        return readfile($file);
    }

    public function audioFile($id){
        $audio = Audio::where('id', $id)->first();
        $file =  base_path('/data') . '/channel-files/' . $audio->audio;
        $type = mime_content_type($file);
        header('Content-Type:' . $type);
        header('Content-Length: ' . filesize($file));
        return readfile($file);
    }

    public function deleteFile($id){
        $img = ProfessionalProfileImage::where('id', $id)->first();
        $img->delete();
        session()->flash('msg', 'Picture Deleted Successfully!');
        return redirect()->back();
    }

    public function professionalDashboard(){
        if (empty(Session::get('userId'))){
            session()->flash('msg', 'Please Login to access Professional Dashboard!');
            return redirect('');
        }
        $professionalId = professionalprofile::where('user_id', Session::get('userId'))->first()['id'];
        $bookingCount = Booking::where('professional_id', $professionalId)->count();
        return view('professional-dashboard.home')->with(['bookingCount' => $bookingCount]);
    }

    public function emailSignup(Request $request){
        $emailSignup = new EmailSignup();
        $emailSignup->email = $request->email;
        $emailSignup->save();
        session()->flash('msg', 'Thanks! We have got your email, we will send latest information to your email');
        return redirect()->back();
    }
}
