<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Loker;
use App\Models\Employer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;



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

    public function employerProfile()
    {
        $employer = Auth('employer')->user();
        $loker = Employer::findOrFail($employer->id)->loadCount('loker');
        return view('employer.profile.index', compact('employer', 'loker'));
    }

    public function updateEmployer(Request $request)
    {
        $employer_id = Auth('employer')->user()->id;
        $employer = Employer::findOrfail($employer_id);
        $validate = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
            'nomor_telepon' => 'required',
            'alamat_email' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Data Pribadi');
        }
        $employer->nama_lengkap = $request->input('nama_lengkap');
        $employer->jabatan = $request->input('jabatan');
        $employer->nomor_telepon = $request->input('nomor_telepon');
        $employer->alamat_email = $request->input('alamat_email');
        $employer->update();
        return back()->with('success', 'Berhasil Mengubah Data Pribadi');
    }

    public function updateCompany(Request $request)
    {
        $employer_id = Auth('employer')->user();
        $employer = Employer::findOrfail($employer_id);
        $validate = Validator::make($request->all(), [
            'nama_perusahaan' => 'required',
            'website' => 'required',
            'tahun_berdiri' => 'required',
            'kantor_pusat' => 'required',
            'kota' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kode_pos' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Profile Perusahaan');
        }
        $employer->nama_perusahaan = $request->input('nama_perusahaan');
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
        $employer_id = Auth('employer')->user()->id;
        $employer = Employer::findOrfail($employer_id);
        $validate = Validator::make($request->all(), [
            'logo_perusahaan' => 'required|mimes:png',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengupload Gambar');
        }
        if ($employer->logo_perusahaan) {
            Storage::delete('/public/logo/' . $employer->logo_perusahaan);
        }

        $newLogo = $employer_id . '.png';
        $request->file('logo_perusahaan')->storeAs('logo', $newLogo);
        $employer->logo_perusahaan = $newLogo;
        $employer->update();
        return back()->with('success', 'Berhasil Mengubah Logo Perusahaan');
    }

    public function index()
    {
        $employer = Auth('employer')->user();
        $loker = Loker::where('employer_id', '=', $employer->id)->orderBy('created_at', 'DESC')->withCount('applicants')->get();
        return view('employer.index', compact('loker', 'employer'));
    }

    public function newLoker(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_pekerjaan' => 'required',
            'jenis_pekerjaan' => 'required',
            'tipe_pekerjaan' => 'required',
            'deskripsi_pekerjaan' => 'required',
            'lokasi_pekerjaan' => 'required',
            'poster' => 'nullable|mimes:png',
            'deadline' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Menambah Loker');
        }

        $loker = new Loker;
        $loker->nama_pekerjaan = $request->input('nama_pekerjaan');
        $loker->jenis_pekerjaan = $request->input('jenis_pekerjaan');
        $loker->tipe_pekerjaan = $request->input('tipe_pekerjaan');
        $loker->deskripsi_pekerjaan = $request->input('deskripsi_pekerjaan');
        $loker->lokasi_pekerjaan = $request->input('lokasi_pekerjaan');
        $loker->status = 'Open';
        $loker->deadline = $request->input('deadline');
        $loker->employer_id = Auth('employer')->user()->id;
        $loker->save();
        if ($request->hasFile('poster')) {
            $posterLoker = $request->file('poster');
            $posterName = $loker->id . '.png';
            $posterLoker->storeAs('poster', $posterName);
            $loker->poster = $posterName;
            $loker->save();
        }
        return redirect('/Employer/Dashboard')->with('success', 'Berhasil Menambah Lowongan Kerja');
    }

    public function detailLoker($id)
    {
        $employer = Auth('employer')->user();
        $loker = $employer->loker->find($id);
        if (!$loker) {
            return back()->with('warning', 'Loker Tidak Ditemukan');
        }
        $applications = $loker->applicants()->orderBy('created_at', 'DESC')->with('user')->get();
        return view('employer.detail-loker', compact('applications', 'employer', 'loker'));
    }

    public function updateLoker(Request $request, $id)
    {
        $employer = Auth('employer')->user();
        $loker = $employer->loker->find($id);

        if (!$loker) {
            return back()->with('warning', 'Loker Tidak Ditemukan');
        }

        $validate = Validator::make($request->all(), [
            'nama_pekerjaan' => 'required',
            'jenis_pekerjaan' => 'required',
            'tipe_pekerjaan' => 'required',
            'status_pekerjaan' => 'nullable',
            'deskripsi_pekerjaan' => 'required',
            'lokasi_pekerjaan' => 'required',
            'poster' => 'nullable|mimes:png',
            'deadline' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Data Loker');
        }
        $loker->nama_pekerjaan = $request->input('nama_pekerjaan');
        $loker->jenis_pekerjaan = $request->input('jenis_pekerjaan');
        $loker->tipe_pekerjaan = $request->input('tipe_pekerjaan');
        $loker->deskripsi_pekerjaan = $request->input('deskripsi_pekerjaan');
        $loker->lokasi_pekerjaan = $request->input('lokasi_pekerjaan');
        if ($request->filled('status_pekerjaan')) {
            $loker->status = 'Open';
        } elseif (!$request->filled('status_pekerjaan')) {
            $loker->status = 'Closed';
        }
        if ($request->hasFile('poster')) {
            Storage::delete('/public/poster/' . $loker->poster);
            $posterName = $loker->id . 'png';
            $request->input('poster')->storeAs('poster' . $posterName);
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
        return redirect('/Employer/Dashboard')->with('success', 'Berhasil Menghapus Loker');
    }

    public function updateApplication(Request $request, $lokerId, $applicantId)
    {
        $employer = Auth('employer')->user();
        $loker = $employer->loker->find($lokerId);
        if (!$loker) {
            return back()->with('warning', 'Loker Tidak Ditemukan');
        }
        $applications = $loker->applicants()->find($applicantId);
        if (!$applications) {
            return back()->with('warning', 'Lamaran Tidak Ditemukan');
        }
        $validation = Validator::make($request->all(), [
            'application_status' => 'required',
            'application_feedback' => 'nullable',
        ]);
        if ($validation->fails()) {
            return back()->with('warning', 'Gagal Mengubah Status Lamaran');
        }
        $applications->status = $request->input('application_status');
        if ($request->input('application_feedback')) {
            $applications->feedback = $request->input('application_feedback');
        }
        $applications->update();
        return back()->with('success', 'Berhasil Mengubah Status Lamaran ' . $applications->user->nama_lengkap);
    }
}
