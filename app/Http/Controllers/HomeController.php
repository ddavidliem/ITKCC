<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Loker;
use App\Models\Employer;
use App\Models\Application;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function UserRegForm()
    {
        return view('auth.register-user');
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    public function EmployerRegForm()
    {
        return view('auth.register-employer');
    }

    public function UserLoginForm()
    {
        return view('auth.login-user');
    }

    public function Carousel()
    {
        $carousel = view('component.carousel')->render();

        return response()->json(array(
            'carousel' => $carousel,
        ));
    }

    public function lokerIndex()
    {
        $time = Carbon::now()->format('Y-m-d');
        $loker = Loker::whereDate('deadline', '>=', $time)->orderBy('created_at', 'DESC')->get();
        return view('user.loker.loker', compact('loker'));
    }

    public function lokerDetail($id)
    {
        $loker = Loker::findOrfail($id);
        $employer_id = data_get($loker, 'employer_id');
        $employer = Employer::findOrfail($employer_id);
        $application = Application::where('loker_id', '=', $id)->count();
        return view('user.loker.loker-detail', compact('loker', 'employer', 'application'));
    }

    public function consultIndex()
    {
        return view('admin.consult.index');
    }
}
