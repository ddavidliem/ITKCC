<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Loker;
use App\Models\Employer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Mail\ApplicationNotification;



class EmployerController extends Controller
{
    public function guard()
    {
        $this->middleware('employer');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function updateEmployer(Request $request)
    {
        $id = Auth('employer')->user()->id;
        $employer = Employer::findOrfail($id);
        $rules = [
            'nama_lengkap' => 'required|string|min:4|max:128',
            'jabatan' => 'required|string|min:4|max:128',
            'nomor_telepon' => 'required|digits_between:10,14',
            'alamat_email' => 'required|email|min:4|max:128',
        ];
        if ($request->input('alamat_email') !== $employer->alamat_email) {
            $rules['alamat_email'] = 'required|email|unique:employers,alamat_email|regex:/@gmail\.com$/i';
        }
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput()->with('modal', 'editEmployer');
        }
        $employer->nama_lengkap = $request->input('nama_lengkap');
        $employer->jabatan = $request->input('jabatan');
        $employer->nomor_telepon = $request->input('nomor_telepon');

        if ($request->input('alamat_email') !== $employer->alamat_email) {
            $newEmail = $request->input('alamat_email');
            $employer->email_verification = null;
            $employer->alamat_email = $newEmail;

            DB::table('tokens')->where('user_id', $employer->id)
                ->where('category', 'employer')
                ->where('type', 'email_verification')
                ->delete();

            $token = Str::random(64);

            DB::table('tokens')->insert([
                'user_id' => $employer->id,
                'alamat_email' => $newEmail,
                'category' => 'employer',
                'token' => $token,
                'type' => 'email_verification',
                'expires_at' => now()->addMinutes(15),
            ]);

            Mail::to($newEmail)->send(new EmailVerification($employer, $token));
        }
        $employer->update();
        return back()->with('success', 'Berhasil Mengubah Data Profile Employer');
    }

    public function updateCompany(Request $request)
    {
        $id = Auth('employer')->user()->id;
        $employer = Employer::findOrfail($id);
        $validate = Validator::make($request->all(), [
            'nama_perusahaan' => 'required|string|min:4|max:128',
            'bidang_perusahaan' => 'required|string|min:4|max:128',
            'website' => 'required|url|min:4|max:128',
            'tahun_berdiri' => 'required|digits:4|numeric|min:1900|max:' . Date('Y'),
            'kantor_pusat' => 'required|string|min:4|max:256',
            'kota' => 'required|string|min:4|max:64',
            'alamat' => 'required|string|min:4|max:256',
            'provinsi' => 'required|string|min:4|max:64',
            'kode_pos' => 'required|digits_between:4,6',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'editCompany');
        }
        $employer->nama_perusahaan = $request->input('nama_perusahaan');
        $employer->bidang_perusahaan = $request->input('bidang_perusahaan');
        $employer->website = $request->input('website');
        $employer->tahun_berdiri = $request->input('tahun_berdiri');
        $employer->kantor_pusat = $request->input('kantor_pusat');
        $employer->kota = $request->input('kota');
        $employer->alamat = $request->input('alamat');
        $employer->provinsi = $request->input('provinsi');
        $employer->kode_pos = $request->input('kode_pos');
        $employer->update();
        return back()->with('success', 'Berhasil Mengubah Profil Perusahaan');
    }

    public function updateLogo(Request $request)
    {
        $id = Auth('employer')->user()->id;
        $employer = Employer::findOrfail($id);
        $validate = Validator::make($request->all(), [
            'logo_perusahaan' => 'required|file|mimes:png|max:2048',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'editLogo');
        }
        if ($employer->logo_perusahaan) {
            Storage::delete('/public/logo' . $employer->logo_perusahaan);
        }
        $newLogo = $id . '.png';
        $request->file('logo_perusahaan')->storeAs('logo', $newLogo);
        $employer->logo_perusahaan = $newLogo;
        $employer->update();
        return back()->with('success', 'Berhasil Mengubah Logo Perusahaan');
    }

    public function index()
    {
        $id = Auth('employer')->user()->id;
        $employer = Employer::findOrfail($id);
        $employer->load(['loker' => function ($query) {
            $query->where('status', '!=', 'Suspended')->orderBy('created_at', 'DESC');
        }, 'loker.applicants']);
        return view('employer.index', compact('employer'));
    }

    public function newLoker(Request $request)
    {
        $id = Auth('employer')->user()->id;
        $employer = Employer::findOrfail($id);
        if (!$employer->logo_perusahaan) {
            return back()->with('warning', 'Tolong Lengkapi Logo Perusahaan');
        }
        $validate = Validator::make($request->all(), [
            'nama_pekerjaan' => 'required|string|min:8|max:128',
            'jenis_pekerjaan' => 'required|string|min:2|max:64',
            'tipe_pekerjaan' => 'required|string|min:2|max:64',
            'deskripsi_pekerjaan' => 'required|string:min:64|max:2048',
            'lokasi_pekerjaan' => 'required|string|min:4|max:128',
            'poster' => 'nullable|file|mimes:png,jpeg|max:2048',
            'deadline' => 'required|date|after_or_equal:today',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput()->with('modal', 'newLoker');
        }

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
        if ($request->hasFile('poster')) {
            $posterLoker = $request->file('poster');
            $posterName = $loker->id . '.png';
            $posterLoker->storeAs('poster', $posterName);
            $loker->poster = $posterName;
            $loker->save();
        }
        return redirect(route('employer.index'))->with('success', 'Berhasil Menambah Lowongan Kerja');
    }

    public function detailLoker($id)
    {
        $employer = Auth('employer')->user();
        $loker = $employer->loker->find($id);
        if (!$loker) {
            return back()->with('warning', 'Loker Tidak Ditemukan');
        }
        if ($loker->status == 'Suspended') {
            return back()->with('warning', 'Loker Tidak Ditemukan');
        }
        $applications = $loker->applicants()->orderBy('created_at', 'DESC')->with('user')->get();

        $status = [
            'labels' => $applications->pluck('status')->toArray(),
            'data' => $applications->groupBy('status')->map->count()->values()->toArray(),
        ];

        $category = [
            'itk' => $applications->where('user.nim', '!=', null)->count(),
            'not_itk' => $applications->where('user.nim', '=', null)->count(),
        ];

        return view('employer.detail-loker', compact('applications', 'employer', 'loker', 'status', 'category'));
    }

    public function updateLoker(Request $request, $id)
    {
        $employer = Auth('employer')->user();
        $loker = $employer->loker->find($id);

        if (!$loker) {
            return back()->with('warning', 'Loker Tidak Ditemukan');
        }
        if ($loker->status == 'suspended') {
            return back()->with('warning', 'Tidak Dapat Mengubah Loker');
        }

        $validate = Validator::make($request->all(), [
            'nama_pekerjaan' => 'required|string|min:8|max:128',
            'jenis_pekerjaan' => 'required|string',
            'tipe_pekerjaan' => 'required|string',
            'deskripsi_pekerjaan' => 'required|string:min:50|max:1024',
            'lokasi_pekerjaan' => 'required|string|min:10|max:512',
            'poster' => 'nullable|file|mimes:png,jpeg|max:2048',
            'deadline' => 'required|date|after_or_equal:today',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput()->with('modal', 'editLoker');
        }
        $loker->nama_pekerjaan = $request->input('nama_pekerjaan');
        $loker->jenis_pekerjaan = $request->input('jenis_pekerjaan');
        $loker->tipe_pekerjaan = $request->input('tipe_pekerjaan');
        $loker->deskripsi_pekerjaan = $request->input('deskripsi_pekerjaan');
        $loker->lokasi_pekerjaan = $request->input('lokasi_pekerjaan');
        $loker->deadline = $request->input('deadline');
        if ($request->filled('status_pekerjaan')) {
            $loker->status = 'Open';
        } elseif (!$request->filled('status_pekerjaan')) {
            $loker->status = 'Closed';
        }
        if ($request->hasFile('poster')) {
            Storage::delete('/public/poster/' . $loker->poster);
            $posterName = $loker->id . '.png';
            $request->file('poster')->storeAs('poster', $posterName);
            $loker->poster = $posterName;
        }
        $loker->update();
        return back()->with('success', 'Berhasil Mengubah Data Loker');
    }

    public function deleteLoker($id)
    {
        $employer = Auth('employer')->user();
        $loker = $employer->loker->find($id);

        if (!$loker) {
            return back()->with('warning', 'Loker Tidak Ditemukan');
        }
        if ($loker->poster) {
            Storage::delete('/public/poster/' . $loker->poster);
        }
        $loker->delete();
        return redirect()->route('employer.index')->with('success', 'Berhasil Menghapus Data Lowongan Kerjad dan Menghapus Seluruh Lamaran Kerja');
    }

    public function updateApplication(Request $request, $lokerId, $applicantId)
    {
        $employer = Auth('employer')->user();
        $loker = $employer->loker->find($lokerId);
        if (!$loker) {
            return back()->with('warning', 'Loker Tidak Ditemukan');
        }
        $application = $loker->applicants()->find($applicantId);
        if (!$application) {
            return back()->with('warning', 'Lamaran Tidak Ditemukan');
        }
        $validation = Validator::make($request->all(), [
            'application_status' => 'required',
            'application_feedback' => 'nullable|string|max:1024',
        ]);
        if ($validation->fails()) {
            return back()->withErrors($validation)->with('modal', 'statusApplication');
        }
        $application->status = $request->input('application_status');
        $application->feedback = $request->input('application_feedback');
        $application->save();

        $template = ($application->status === 'accepted') ? 'employer.mail.accepted' : 'employer.mail.declined';
        $feedback = $application->feedback;
        Mail::to($application->user->alamat_email)->send(new ApplicationNotification($application, $template, $feedback));
        return back()->with('success', 'Berhasil Mengubah Status Lamaran ' . $application->nama_lengkap);
    }
}
