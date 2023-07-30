<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\User;
use App\Http\Middleware\Employer;

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

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/login/user', 'UserLoginForm');
    Route::get('/refresh-captcha', 'refreshCaptcha');
    Route::get('/carousel', 'Carousel');

    Route::get('/render-loker-list', 'lokerList');
    Route::get('/loker/{id}', 'lokerDetail');
    Route::get('/loker', 'lokerIndex');

    Route::get('/consult', 'consultIndex');
});

Route::controller(AuthController::class)->middleware('guest')->group(function () {
    Route::post('/register-user', 'UserReg');
    Route::get('/register-user-form', 'UserRegForm');
    Route::post('/login-user', 'UserLogin');
    Route::get('/forget-password', 'ForgetPasswordForm')->name('forget.password.get');
    Route::post('/forget-password', 'submitForgetPassword')->name('forget.password.post');
    Route::get('/reset-password/{token}', 'ResetPasswordForm')->name('reset.password.get');
    Route::post('/submit-reset-password', 'submitResetPassword')->name('reset.password.post');


    Route::get('/register-employer', 'EmployerRegForm');
    Route::post('/employer-submit-approval', 'EmployerApproval');


    Route::post('/login-employer', 'EmployerLogin');
    Route::get('/employer-login-form', 'EmployerLoginForm');
    Route::get('/forget-password-employer');
    Route::post('/forget-password-employer');
    Route::get('/reset-password/{token}');
    Route::post('/submit-reset-password-employer');

    Route::get('/login-admin', 'adminLoginForm');
    Route::post('/admin-sign-in', 'adminLogin');
});

Route::controller(UserController::class)->middleware('user')->group(function () {
    Route::get('/Home/User', 'index');
    Route::get('/logout-user', 'logout');

    Route::get('/Home/Pendidikan', 'pendidikan');
    Route::get('/get-pendidikan/{id}');

    Route::get('/Home/User/Profile', 'indexProfile');
    Route::get('/render-profile', 'renderProfile');
    Route::post('/update-user-data', 'updateProfile');

    Route::post('/submit-pendidikan', 'addPendidikan');
    Route::post('/submit-sertifikat', 'addSertifikat');
    Route::post('/submit-pengalaman', 'addPengalaman');

    Route::get('/Home/User/Application', 'indexApplication');
    Route::get('/Home/User/Resume', 'indexResume');
    Route::POST('/update-resume', 'updateResume');
    Route::POST('/update-profile-image', 'imgProfile');

    Route::get('/Home/User/Appointment', 'indexAppointment');
    Route::get('/appointment-form', 'AppointmentForm');
    Route::post('/create-appointment', 'createAppointment');



    Route::POST('/submit-application/{id}', 'submitApplication');
});

Route::controller(EmployerController::class)->middleware('employer')->group(function () {
    Route::get('/employer/dashboard', 'index');

    Route::get('/render-loker', 'renderLoker');
    Route::get('/new-loker-form', 'lokerForm');
    Route::post('/tambah-loker', 'newLoker');
    Route::get('/loker-detail/{id}', 'detailLoker');

    Route::get('/profile/{id}', 'employerProfile');
    Route::post('/employer-update-logo', 'employerUpdateLogo');

    Route::get('/Applicant-list/{id}', 'listApplication');
    Route::get('/pelamar/{id}', 'applicantDetail');
    Route::patch('/Approve-application/{id}', 'approval');

    Route::get('/logout-employer', 'logout');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/registration-form');
    Route::post('/submit-form');
});

Route::controller(AdminController::class)->middleware('admin')->group(function () {
    Route::get('/dashboard', 'index');

    Route::get('/approval', 'approvalPage');
    Route::post('approval-approved/{id}', 'approvalEmployer');

    Route::get('/employer', 'employerIndex');
    Route::get('/render-appointments', 'renderAppointments');
    Route::get('/filter-appointment', 'filterAppointments');
    Route::get('/events', 'events');
    Route::get('/appointment', 'appointmentIndex');

    Route::get('/logout-admin', 'logout');
});
