<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', "UserController@landing");
Route::get('/professional-dashboard', "UserController@professionalDashboard");
Route::get('/customer-dashboard', "Customer@profile");
Route::get('/customer-favourites', "Customer@favourites");

Route::get('/professional-profile', "ProfessionalController@profile");
Route::get('/professional-favourites', "ProfessionalController@favourites");
Route::get('/professional-bookings', "ProfessionalController@bookings");
Route::get('/professional-chats', "ProfessionalController@chats");
Route::get('/book-professional/{id}', "ProfessionalController@bookProfessionalPage");
Route::post('/search-result', "ProfessionalController@searchResult");
Route::post('/email-signup', "UserController@emailSignup");
Route::post('/book-professional', "ProfessionalController@bookProfessional");
Route::get('/client-bookings', "Customer@bookings");
Route::get('/booking-accept/{id}', "BookingController@accept");
Route::get('/booking-reject/{id}', "BookingController@reject");
Route::get('/booking-complete/{id}', "BookingController@complete");

Route::post('/userlogin', "UserController@login");
Route::post('/usersignup', "UserController@signup");
Route::post('/save-contactus', "UserController@saveContactus");
Route::post('/save-professional-registration', "UserController@saveProfessionalRegistration");
Route::post('/update-professional-registration', "UserController@updateProfessionalRegistration");
Route::post('/update-customer-registration', "UserController@updateCustomerRegistration");
Route::get('/user-logout', "UserController@logout");
Route::get('/user-file/{id}', "UserController@userFile");
Route::get('/user-profile/{id}', "UserController@userProfile");
Route::get('/audio-photo/{id}', "UserController@audioPhoto");
Route::get('/audio-file/{id}', "UserController@audioFile");
Route::get('/trendings', "UserController@trending");
Route::get('/channels', "UserController@channels");
Route::get('/delete-file/{id}', "UserController@deleteFile");
Route::get('/my-channel', "UserController@myChannel");
Route::get('/saved-audio', "UserController@getsavedAudio");
Route::get('/unsave-audio/{id}', "UserController@unsaveAudio");
Route::get('/unlike-audio/{id}', "UserController@unLikedAudio");
Route::get('/create-channel', "UserController@createChannel");
Route::get('/edit-channel/{id}', "UserController@editChannel");
Route::get('/edit-audio/{id}', "UserController@editAudio");
Route::get('/upload-audio', "UserController@uploadnewAudio");
Route::get('/audio-details/{id}', "UserController@audioDetails");
Route::get('/channel-details/{id}', "UserController@channelDetails");
Route::get('/subscribe/{id}', "UserController@subscribe");
Route::get('/delete-audio/{id}', "UserController@deleteAudio");
Route::get('/unsubscribe/{id}', "UserController@unsubscribe");
Route::get('/like-audio/{id}', "UserController@likeAudio");
Route::get('/save-audio/{id}', "UserController@saveAudio");
Route::get('/notifications', "UserController@notifications");
Route::get('/broadcasting', "UserController@recordLive");
Route::post('/editchannelbackend', "UserController@editchannelbackend");
Route::post('/uploadupdatedaudio', "UserController@uploadupdatedaudio");
Route::post('/uploadaudio', "UserController@uploadaudio");
Route::post('/createchannel', "UserController@createChannelBackend");
Route::post('/addcomment', "UserController@addcomment");
Route::post('/search-audio', "UserController@searchAudio");
Route::get('/user-login', function () {
    return view('landing.user-login');
});
Route::get('/user-signup', function () {
    return view('landing.user-signup');
});
Route::get('/aboutus', function () {
    return view('landing.aboutus');
});
Route::get('/contactus', function () {
    return view('landing.contactus');
});
Route::get('/professional-registration', function () {
    return view('landing.professional-registration');
});

Auth::routes();
Route::get('/admin', "AdminController@loginPage")->middleware('checkAuth');
Route::post('/admin/login', "AdminController@login")->name('admin.login');
//Route::get('admin-dashboard', "AdminController@adminDashboard");
Route::post('admin-logout', "AdminController@logout")->name('admin.logout');

Route::get('logout-user', function (){
    \Illuminate\Support\Facades\Session::flush();
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/admin');
})->name('logout-user');




Route::post('login', "AdminController@login")->name('login');

Route::get('/home', "HomeController@showDashboard")->middleware('dashboard');
Route::get('/clients', "HomeController@clients")->middleware('dashboard');
Route::get('/professionals', "HomeController@professionals")->middleware('dashboard');
Route::get('/all-bookings', "HomeController@bookings")->middleware('dashboard');
//Route::get('/chat', "HomeController@chat")->middleware('dashboard');
//Route::get('/chat-details/{id}', "HomeController@chatDetails")->middleware('dashboard');
//Route::post('/send-sms/{parentId}', "HomeController@sendSMS");

//Route::get('staff', 'StaffController@getStaffListView')->middleware('dashboard');
//Route::get('add-staff', "StaffController@getAddStaffView")->middleware('dashboard');
//Route::post('save-staff', "StaffController@saveStaff");
//Route::get('delete-staff/{id}', "StaffController@deleteStaff")->middleware('dashboard');
//Route::get('edit-staff/{id}', "StaffController@editStaff")->middleware('dashboard');
//Route::post('save-edited-staff', "StaffController@saveEditedStaff");

//Route::get('customer', 'CustomerController@getCustomerListView')->middleware('dashboard');
//Route::get('add-customer', "CustomerController@getAddCustomerView")->middleware('dashboard');
//Route::post('save-cus/tomer', "CustomerController@saveCustomer");
//Route::get('delete-custo/mer/{id}', "CustomerController@deleteCustomer")->middleware('dashboard');
//Route::get('edit-customer/{id}', "CustomerController@editCustomer")->middleware('dashboard');
//Route::post('save-edited-customer', "CustomerController@saveEditedCustomer");

//Route::get('message-template', 'MessageTemplateController@getMessageTemplateListView')->middleware('dashboard');
//Route::get('add-message-template', "MessageTemplateController@getAddMessageTemplateView")->middleware('dashboard');
//Route::post('save-message-template', "MessageTemplateController@saveMessageTemplate");
//Route::get('delete-message-template/{id}', "MessageTemplateController@deleteMessageTemplate")->middleware('dashboard');
//Route::get('edit-message-template/{id}', "MessageTemplateController@editMessageTemplate")->middleware('dashboard');
//Route::post('save-edited-message-template', "MessageTemplateController@saveEditedMessageTemplate");

//Route::post('login-staff', "StaffController@login");
//Route::post('send-sms-to-checked', "CustomerController@sendSmsToChecked");
//Route::post('send-sms-to-checked-customers', "CustomerController@sendSmsToCheckedCustomer");
//Route::post('delete-checked-customers', "CustomerController@deleteCheckedCustomer");
//Route::post('delete-checked-chats', "CustomerController@deleteCheckedChats");
//Route::post('customers/all', "CustomerController@getAll");
//Route::post('chats/all', "CustomerController@getAllChats");

//Route::post('/import_excel/import', 'ImportExcelController@import');
//Route::get('icoming-sms', 'HomeController@icomingSms');
