<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Loker;
use App\Models\Application;
use App\Models\Content;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $carousel = Content::where('category', '=', 'Carousel')->get();
        $lokers = Loker::where('status', 'Open')
            ->where('Deadline', '>=', now())
            ->latest()
            ->take(9)
            ->get();
        $chunkLokers = $lokers->chunk(3);
        return view('welcome', compact('carousel', 'chunkLokers'));
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
        return view('consult.index');
    }

    public function beritaIndex()
    {
        $content = Content::where('category', 'berita')->get();
        return view('content.index', compact('content'));
    }

    public function beritaDetail($id)
    {
        $content = Content::findOrfail($id);
        if (!$content) {
            return back()->with('warning', 'Berita Tidak Ditemukan');
        }
        return view('content.detail', compact('content'));
    }
}
