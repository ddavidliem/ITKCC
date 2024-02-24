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
    Route::get('/loker/{id}', 'lokerDetail');
    Route::get('/loker', 'lokerIndex');
    Route::get('/konsultasi', 'konsultasiIndex');
    Route::get('/berita', 'beritaIndex');
    Route::get('/berita/{id}', 'beritaDetail');
});

Route::controller(AuthController::class)->middleware('guest')->group(function () {
    Route::post('/register-user', 'UserReg')->name('auth.register.user');
    Route::get('/register-user-form', 'UserRegForm')->name('auth.register.form.user');
    Route::post('/login-user', 'UserLogin')->name('auth.login.user');
    Route::get('/login/user', 'UserLoginForm')->name('auth.login.form.user');

    Route::get('/email-verification', 'indexVerification')->name('auth.email.verification');
    Route::get('/verify-email/{token}', 'emailVerify')->name('auth.email.verification.token');
    Route::patch('/send/email-verification', 'resendVerificationMail')->name('auth.email.verification.resend');
    Route::get('/refresh-captcha', 'refreshCaptcha');

    Route::get('/forgot-password', 'forgotPasswordIndex')->name('auth.reset.password.form');
    Route::post('/reset-password-link', 'resetPasswordMail')->name('auth.reset.password.link');
    Route::get('/reset-password/form/{token}', 'resetPasswordForm')->name('auth.reset.password.token')->middleware('verifytoken');
    Route::post('/reset-password', 'resetPassword')->name('auth.reset.password');

    Route::get('/register-employer-form', 'EmployerRegForm')->name('auth.register.employer');
    Route::post('/employer-submit-approval', 'EmployerApproval')->name('auth.register.employer.approval');
    Route::post('/login-employer', 'EmployerLogin')->name('auth.login.employer.form');
    Route::get('/login/employer', 'EmployerLoginForm')->name('auth.login.employer');

    Route::get('/login/admin/form', 'adminLoginForm');
    Route::post('/login/admin', 'adminLogin');

    Route::get('auth.google.{type}', 'redirectGoogle')->name('auth.google');
    Route::get('/login/google/callback', 'callback');
});

Route::controller(UserController::class)->middleware('user')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', 'index')->name('user.index');
        Route::get('/logout', 'logout')->name('user.logout');

        Route::prefix('profile')->group(function () {
            Route::put('/update', 'updateProfile')->name('user.profile.update');
            Route::put('/resume/update', 'updateResume')->name('user.profile.resume.update');
            Route::put('/profile/update', 'imgProfile')->name('user.profile.image.update');
        });

        Route::prefix('sertifikat')->group(function () {
            Route::post('/new', 'addSertifikat')->name('user.sertifikat.new');
            Route::get('/{id}/detail', 'detailSertifikat')->name('user.sertifikat.detail');
            Route::put('/{id}/update', 'updateSertifikat')->name('user.sertifikat.update');
            Route::delete('/{id}/delete', 'deleteSertifikat')->name('user.sertifikat.delete');
        });

        Route::prefix('pendidikan')->group(function () {
            Route::post('/new', 'addPendidikan')->name('user.pendidikan.new');
            Route::get('/{id}/detail', 'detailPendidikan')->name('user.pendidikan.detail');
            Route::put('/{id}/update', 'updatePendidikan')->name('user.pendidikan.update');
            Route::delete('/{id}/delete', 'deletePendidikan')->name('user.pendidikan.delete');
        });

        Route::prefix('pengalaman')->group(function () {
            Route::post('/new', 'addPengalaman')->name('user.pengalaman.new');
            Route::get('/{id}/detail', 'detailPengalaman')->name('user.pengalaman.detail');
            Route::put('/{id}/update', 'updatePengalaman')->name('user.pengalaman.update');
            Route::delete('/{id}/delete', 'deletePengalaman')->name('user.pengalaman.delete');
        });

        Route::prefix('appointment')->group(function () {
            Route::get('/index', 'indexAppointment')->name('user.appointment');
            Route::get('/form', 'AppointmentForm')->name('user.appointment.form');
            Route::post('/new', 'createAppointment')->name('user.appointment.create');
            Route::put('/{id}/update', 'editAppointment')->name('user.appointment.update');
            Route::get('/{id}/detail', 'detailAppointment')->name('user.appointment.detail');
        });

        Route::prefix('application')->group(function () {
            Route::post('/{id}/submit', 'submitApplication')->name('user.application.submit');
        });
    });
});

Route::controller(EmployerController::class)->middleware('employer')->group(function () {
    Route::prefix('employer')->group(function () {
        Route::get('/', 'index')->name('employer.index');
        Route::get('/logout', 'logout')->name('employer.logout');

        Route::prefix('profile')->group(function () {
            Route::put('/update/profile', 'updateEmployer')->name('employer.profile.update');
            Route::put('/update/company', 'updateCompany')->name('employer.profile.company.update');
            Route::put('/update/logo', 'updateLogo')->name('employer.profile.logo');
        });

        Route::prefix('loker')->group(function () {
            Route::post('/new', 'newLoker')->name('employer.loker.new');
            Route::get('/{id}/detail', 'detailLoker')->name('employer.loker.detail');
            Route::put('/{id}/update', 'updateLoker')->name('employer.loker.update');
            Route::delete('/{id}/delete', 'deleteLoker')->name('employer.loker.delete');

            Route::prefix('application')->group(function () {
                Route::put('/loker/{loker}/application/{application}', 'updateApplication')->name('employer.loker.application.respond');
            });
        });
    });
});

Route::controller(AdminController::class)->middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', 'index')->name('admin');
    Route::get('/logout-admin', 'logout')->name('admin.logout');
    Route::post('/reset-password', 'resetPassword')->name('admin.reset-password');

    Route::prefix('contents')->group(function () {
        Route::get('/', 'contentIndex')->name('admin.contents');
        Route::post('/create-content', 'newContent')->name('admin.contents.create');
        Route::get('/detail/{id}', 'detailContent')->name('admin.contents.detail');
        Route::put('/update/{id}', 'updateContent')->name('admin.contents.update');
        Route::delete('/delete/{id}', 'deleteContent')->name('admin.contents.delete');
    });

    Route::prefix('approval')->group(function () {
        Route::get('/', 'approvalPage', 'approvalUpdate')->name('admin.approval');
        Route::delete('/{id}/delete', 'approvalDelete')->name('admin.approval.delete');
        Route::put('/{id}/update', 'approvalUpdate')->name('admin.approval.update');
    });

    Route::prefix('appointment')->group(function () {
        Route::get('/', 'appointmentIndex')->name('admin.appointment');
        Route::put('/{id}/updateStatus', 'appointmentResponse')->name('admin.appointment.response');
        Route::delete('/{id}/delete', 'appointmentDelete')->name('admin.appointment.delete');
        Route::post('/{id}/new', 'appointmentNew')->name('admin.appointment.new');
        Route::put('/{id}/edit', 'appointmentEdit')->name('admin.appointment.update');
        Route::get('/{id}detail', 'appointmentDetail')->name('admin.appointment.detail');

        Route::prefix('topik')->group(function () {
            Route::put('/{id}/edit', 'topicUpdate')->name('admin.appointment.topik.update');
            Route::delete('/{id}/delete', 'topicDelete')->name('admin.appointment.topik.delete');
            Route::post('/new', 'topicNew')->name('admin.appointment.topik.new');
        });
    });

    Route::prefix('employer')->group(function () {
        Route::get('/', 'employerIndex')->name('admin.employer');
        Route::get('/{id}/detail', 'employerDetail')->name('admin.employer.detail');
        Route::put('/{id}/update', 'employerUpdate')->name('admin.employer.edit');
        Route::delete('/{id}/delete', 'employerDelete')->name('admin.employer.delete');
    });

    Route::prefix('loker')->group(function () {
        Route::get('/', 'lokerIndex')->name('admin.loker');
        Route::get('/{id}/detail', 'lokerDetail')->name('admin.loker.detail');
        Route::put('/{id}/update', 'lokerUpdate')->name('admin.loker.update');
        Route::delete('/{id}/delete', 'lokerDelete')->name('admin.loker.delete');
    });

    Route::prefix('application')->group(function () {

        Route::delete('/{id}/delete', 'applicationDelete')->name('admin.application.delete');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', 'userIndex')->name('admin.user');
        Route::get('/{id}/detail', 'userDetail')->name('admin.user.detail');
        Route::put('/{id}/update', 'userUpdate')->name('admin.user.update');
        Route::delete('/{id}/delete', 'userDelete')->name('admin.user.delete');

        Route::prefix('sertifikat')->group(function () {
            Route::get('/{user}/detail/{id}', 'detailSertifikat')->name('admin.user.sertifikat.detail');
            Route::put('/{user}/update/{id}', 'updateSertifikat')->name('admin.user.sertifikat.update');
            Route::delete('/{user}/delete/{id}', 'deleteSertifikat')->name('admin.user.sertifikat.delete');
        });

        Route::prefix('pengalaman')->group(function () {
            Route::get('/{user}/detail/{id}', 'detailPengalaman')->name('admin.user.pengalaman.detail');
            Route::put('/{user}/update/{id}', 'updatePengalaman')->name('admin.user.pengalaman.edit');
            Route::delete('/{user}/delete/{id}', 'deletePengalaman')->name('admin.user.pengalaman.delete');
        });

        Route::prefix('pendidikan')->group(function () {
            Route::get('/{user}/detail/{id}', 'detailPendidikan')->name('admin.user.pendidikan.detail');
            Route::put('/{user}/update/{id}', 'updatePendidikan')->name('admin.user.pendidikan.update');
            Route::delete('/{user}/delete/{id}', 'deletePendidikan')->name('admin.user.pendidikan.delete');
        });
    });

    Route::prefix('prodi')->group(function () {
        Route::post('/new', 'prodiNew')->name('admin.prodi.new');
        Route::get('/{id}/detail', 'prodiDetail')->name('admin.prodi.detail');
        Route::put('/{id}/update', 'prodiUpdate')->name('admin.prodi.update');
        Route::delete('/{id}/delete', 'prodiDelete')->name('admin.prodi.delete');
    });
});
