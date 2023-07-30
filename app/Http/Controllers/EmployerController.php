<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\Loker;
use App\Models\Employer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


class EmployerController extends Controller
{

    public function index()
    {
        $id = Auth('employer')->user()->id;
        $employer = Employer::findOrfail($id);
        $loker = Loker::where('employer_id', '=', $id)->withCount('applicants')->get();
        return view('employer.index', compact('employer', 'id', 'loker'));
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function lokerForm()
    {
        return view('employer.create');
    }

    public function newLoker(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_pekerjaan' => 'required',
            'jenis_pekerjaan' => 'required',
            'tipe_pekerjaan' => 'required',
            'deskripsi_pekerjaan' => 'required',
            'deadline' => 'date'
        ]);


        if ($validate->fails()) {
            return Redirect::back()->withErrors($validate);
        } else {
            if (!empty($request->input('poster'))) {
                $id = Auth('employer')->user()->id;
                $img = $request->poster;
                $poster_name = $id . time() . '.' . $img->extension();
                $loker = new Loker;
                $loker->nama_pekerjaan = $request->input('nama_pekerjaan');
                $loker->jenis_pekerjaan = $request->input('jenis_pekerjaan');
                $loker->tipe_pekerjaan = $request->input('tipe_pekerjaan');
                $loker->deskripsi_pekerjaan = $request->input('deskripsi_pekerjaan');
                $loker->lokasi_pekerjaan = $request->input('lokasi_pekerjaan');
                $loker->status = 'Open';
                $loker->poster = $poster_name;
                $loker->deadline = $request->input('deadline');
                $loker->employer_id = $id;
                $loker->save();
                $img->storeAs('poster', $poster_name);
                return redirect('/employer/dashboard')->with('success', 'Berhasil Membuat Loker Baru');
            } else {
                $id = Auth('employer')->user()->id;
                $loker = new Loker;
                $loker->nama_pekerjaan = $request->input('nama_pekerjaan');
                $loker->jenis_pekerjaan = $request->input('jenis_pekerjaan');
                $loker->tipe_pekerjaan = $request->input('tipe_pekerjaan');
                $loker->deskripsi_pekerjaan = $request->input('deskripsi_pekerjaan');
                $loker->lokasi_pekerjaan = $request->input('lokasi_pekerjaan');
                $loker->status = 'Open';
                $loker->deadline = $request->input('deadline');
                $loker->employer_id = $id;
                $loker->save();
                return redirect('/employer/dashboard')->with('success', 'Berhasil Membuat Loker Baru');
            }
        }
    }

    public function editLoker($id)
    {
        $loker = Loker::find($id);
        return view('employer.edit', compact($loker));
    }

    public function updateLoker(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'nama_pekerjaan' => 'required',
            'jenis_pekerjaan' => 'required',
            'deskripsi_pekerjaan' => 'required',
            'kota' => 'nullable',
            'poster' => 'nullable',
            'status' => 'required',
            'deadline' => 'nullable',
        ]);

        if ($validate->fails()) {
            return Redirect::back()->withErrors($validate);
        } else {
            $loker = Loker::find($id);
            $loker->nama_pekerjaan = $request->input('nama_pekerjaan');
            $loker->jenis_pekerjaan = $request->input('jenis_pekerjaan');
            $loker->deskripsi_pekerjaan = $request->input('deskripsi_pekerjaan');
            $loker->kota = $request->input('lokasi');
            $loker->poster = $request->input('poster');
            $loker->status = $request->input('status');
            $loker->deadline = $request->input('deadline');
            $loker->update();
            return redirect('/employer/dashboard')->with('success', 'Berhasil Membuat Loker Baru');
        }
    }

    public function deleteLoker($id)
    {
        $loker = Loker::find($id);
        $poster_path = public_path('poster/{$loker->poster}');
        if ($loker) {
            if (File::exists($poster_path)) {
                $loker->delete();
                File::delete($poster_path);
            }
        } else {
            return back();
        }
    }

    public function renderLoker()
    {
        $id = Auth('employer')->user()->id;
        $time = Carbon::now()->format('Y-m-d');

        $employer = Employer::where('id', '=', $id);
        $loker = Loker::where('employer_id', '=', $id)->orderBy('created_at', 'DESC')->get();

        $loker_employer = view('employer.render.render-dashboard', compact('loker', 'employer'))->render();
        return response()->json(array(
            'loker' => $loker_employer,
        ));
    }

    public function detailLoker(Request $request, $id)
    {
        $loker = Loker::findOrfail($id);
        $applications = Application::where('loker_id', '=', $id)->orderBy('created_at', 'ASC')->with('user')->get();
        $count = Application::where('loker_id', '=', $id)->count();
        return view('employer.detail-loker', compact('loker', 'applications', 'count'));
    }

    public function employerProfile($id)
    {
        $employer = Employer::findOrfail($id);
        return view('employer.profile.index', compact('employer'));
    }

    public function employerUpdateLogo(Request $request)
    {
        $id = Auth('employer')->user()->id;
        $employer = Employer::find($id);
        $lg = data_get($employer, 'logo_perusahaan');
        $validate = Validator::make($request->all(), [
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validate->fails()) {
            return Redirect::back()->withErrors($validate);
        } else {
            if (Storage::fileExists('/public/logo/' . $lg)) {
                Storage::delete('/public/logo/' . $lg);
                $logo = $request->logo;
                $logo_name = $id . 'logo' . '.' . $logo->extension();
                $employer->logo_perusahaan = $logo_name;
                $employer->update();
                $logo->storeAs('logo', $logo_name);
                return back()->with('success', 'Berhasil Mengupload Logo Perusahaan');
            } else {
                $logo = $request->logo;
                $logo_name = $id . 'logo' . '.' . $logo->extension();
                $employer->logo_perusahaan = $logo_name;
                $employer->update();
                $logo->storeAs('logo', $logo_name);
                return back()->with('success', 'Berhasil Menambah Logo Perusahaan');
            }
        }
    }


    public function approval($id)
    {
        $approval = Application::findOrfail($id);
        $approval->status = 'Approved';
        $approval->update();
        return back()->with('success', 'Lamaran Telah Di setujui');
    }
}
