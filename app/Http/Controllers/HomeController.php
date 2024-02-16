<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Loker;
use App\Models\Employer;
use App\Models\Application;
use App\Models\Content;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $carousel = Content::where('category', '=', 'Carousel')->get();
        return view('welcome', compact('carousel'));
    }

    public function UserRegForm()
    {
        return view('auth.register-user');
    }

    public function EmployerRegForm()
    {
        return view('auth.register-employer');
    }

    public function lokerIndex()
    {
        $time = Carbon::now()->format('Y-m-d');
        $loker = Loker::whereDate('deadline', '>=', $time)->where('status', '=', 'Open')->orderBy('created_at', 'DESC')->withCount('applicants')->get();
        return view('user.loker.loker', compact('loker'));
    }

    public function lokerDetail($id)
    {
        $loker = Loker::findOrfail($id);
        $loker->load('employer')->load('applicants')->loadCount('applicants');
        if (Auth()->check()) {
            $user = Auth::user();
            $hasApplication = $loker->applicants()->where('user_id', $user->id)->exists();
            return view('user.loker.loker-detail', compact('loker', 'user', 'hasApplication'));
        }
        return view('user.loker.loker-detail', compact('loker'));
    }

    public function konsultasiIndex()
    {
        return view('admin.consult.index');
    }
}
