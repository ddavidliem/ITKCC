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
    Route::get('/render-loker-list', 'lokerList');
    Route::get('/loker/{id}', 'lokerDetail');
    Route::get('/loker', 'lokerIndex');
    Route::get('/konsultasi', 'konsultasiIndex');
    Route::post('/loker/result', 'searchLoker');
});

Route::controller(AuthController::class)->middleware('guest')->group(function () {
    Route::post('/register-user', 'UserReg');
    Route::get('/register-user-form', 'UserRegForm');
    Route::post('/login-user', 'UserLogin');
    Route::get('/login/user', 'UserLoginForm');

    Route::get('/email-verification', 'indexVerification');
    Route::get('/verify-email/{token}', 'emailVerify');
    Route::patch('/send/email-verification', 'resendVerificationMail');
    Route::get('/refresh-captcha', 'refreshCaptcha');

    Route::get('/reset-password', 'resetPasswordIndex');
    Route::post('/send/reset-password-link', 'resetPasswordMail');

    Route::get('/register-employer-form', 'EmployerRegForm');
    Route::post('/employer-submit-approval', 'EmployerApproval');
    Route::post('/login-employer', 'EmployerLogin');
    Route::get('/login/employer', 'EmployerLoginForm');
    Route::get('/register-form-template', 'templateDownload');

    Route::get('/login/admin/form', 'adminLoginForm');
    Route::post('/login/admin', 'adminLogin');
});

Route::controller(UserController::class)->middleware('user')->group(function () {
    Route::get('/Home/User', 'index');
    Route::get('/logout-user', 'logout');

    Route::get('/Home/Pendidikan', 'pendidikan');
    Route::post('/submit-pendidikan', 'addPendidikan');
    Route::get('/get-pendidikan/{id}');

    Route::get('/Home/User/Profile', 'indexProfile');
    Route::get('/render-profile', 'renderProfile');
    Route::put('/update-user-data', 'updateProfile');

    Route::post('/submit-sertifikat', 'addSertifikat');
    Route::get('/Home/User/Sertifikat', 'indexSertifikat');
    Route::put('/update-sertifikat/{id}', 'updateSertifikat');
    Route::delete('/delete-sertifikat/{id}', 'deleteSertifikat');

    Route::post('/submit-pengalaman', 'addPengalaman');
    Route::get('/Home/User/Pengalaman', 'indexPengalaman');
    Route::put('/update-pengalaman/{id}', 'updatePengalaman');
    Route::delete('/delete-pengalaman/{id}', 'deletePengalaman');

    Route::get('/Home/User/Resume', 'indexResume');
    Route::put('/update-resume', 'updateResume');
    Route::put('/update-profile-image', 'imgProfile');

    Route::get('/Home/User/Appointment', 'indexAppointment');
    Route::get('/konsultasi/formulir', 'AppointmentForm');
    Route::post('/new-appointment', 'createAppointment');
    Route::put('/edit-appointment/{id}', 'editAppointment');
    Route::get('/Home/User/Appointment/{id}', 'detailAppointment');

    Route::get('/Home/User/Application', 'indexApplication');
    Route::get('/Home/User/Application/{id}', 'detailApplication');
    Route::post('/submit-application/{id}', 'submitApplication');
});

Route::controller(EmployerController::class)->middleware('employer')->group(function () {
    Route::get('/Employer/Dashboard', 'index');

    Route::get('/Employer/Profile', 'employerProfile');
    Route::put('/update-employer', 'updateEmployer');
    Route::put('/update-company', 'updateCompany');
    Route::put('/update-logo-company', 'updateLogo');

    Route::post('/new-loker', 'newLoker');
    Route::get('/Employer/Loker/{id}', 'detailLoker');
    Route::put('/update-loker/{id}', 'updateLoker');
    Route::delete('/delete-loker/{id}', 'deleteLoker');

    Route::put('/Employer/{loker}/applicant/{applicant}', 'updateApplication');

    Route::get('/logout-employer', 'logout');
});

Route::controller(AdminController::class)->middleware('admin')->group(function () {
    Route::get('/dashboard', 'index');

    Route::get('/contents/carousel', 'carouselPage');
    Route::post('/contents/carousel/new', 'carouselNew');
    Route::get('/contents/carousel/{id}', 'carouselDetail');
    Route::put('/contents/carousel/{id}/update', 'carouselUpdate');
    Route::delete('/contents/carousel/{id}/delete', 'carouselDelete');

    Route::get('/contents', 'contentIndex');
    Route::get('/contents/new/form', 'formContent');
    Route::post('/contents/new', 'newContent');
    Route::get('/contents/{id}', 'contentDetail');
    Route::put('/contents/{id}/update', 'updateContent');
    Route::delete('/contents/{id}/delete', 'deleteContent');

    Route::get('/approval', 'approvalPage');
    Route::put('/update-approval/{id}', 'approvalUpdate');

    Route::get('/employer', 'employerIndex');
    Route::get('/render-appointments', 'renderAppointments');
    Route::get('/filter-appointment', 'filterAppointments');
    Route::get('/events', 'events');
    Route::get('/appointment', 'appointmentIndex');

    Route::get('/logout-admin', 'logout');
});
