<?php

namespace App\Http\Controllers;

use App\Models\Pendidikan;
use App\Models\Pengalaman;
use App\Models\Sertifikasi;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use DateTime;
use App\Models\Application;
use App\Models\Loker;
use App\Models\Employer;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function guard()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::findOrfail($user_id);
        $appointment = Appointment::where('user_id', '=', $user_id)->count();
        $application = Application::where('user_id', '=', $user_id)->count();
        $loker = Loker::orderBy('created_at', 'asc')->take(3)->get();
        return view('user.index', compact('user', 'loker', 'appointment', 'application'));
    }

    public function renderProfile()
    {
        $user_id = Auth::user()->id;
        $user = User::findOrfail($user_id);
        $pendidikan = Pendidikan::where('user_id', '=', $user_id)->OrderBy('created_at', 'DESC')->get();
        $pengalaman = Pengalaman::where('user_id', '=', $user_id)->OrderBy('created_at', 'DESC')->get();
        $sertifikasi = Sertifikasi::where('user_id', '=', $user_id)->OrderBy('created_at', 'DESC')->get();
        $user_data = view('user.render.render-profile', compact('user', 'pengalaman', 'pendidikan', 'sertifikasi'))->render();
        return response()->json(array(
            'profile' => $user_data,
        ));
    }

    public function indexProfile()
    {
        $user_id = Auth::user()->id;
        $user = User::findOrfail($user_id);
        return view('user.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::findOrfail($user_id);
        if ($user) {
            $validate = Validator::make($request->all(), [
                ''
            ]);
            if ($validate) {
            } else {
                return back()->with('success', 'Berhasil Mengubah Data User');
            }
        } else {
            return back()->with('warning', 'Tidak Bisa Mengubah Data User');
        }
    }

    public function UserUpdateTag(Request $request)
    {
        $user_id = Auth::user()->id;
        $validate = Validator::make($request->all, []);

        if ($validate) {
        } else {
        }
    }

    public function imgProfile(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::findOrfail($user_id);
        $profileImg = data_get($user, 'profile');
        $user_img = $request->file('profile_img');
        $validate = Validator::make($request->all(), [
            'profile_img' => 'required|mimes:pdf|max:10000'
        ]);

        if ($validate) {
            if (Storage::fileExists('/public/profile/' . $profileImg)) {
                Storage::delete('/public/profile/' . $profileImg);
                $img_id = $user_id . '.' . $user_img->extension();
                $user_img->storeAs('profile', $img_id);
                $user->profile = $img_id;
                $user->update();
                return redirect('/Home/User/Profile')->with('success', 'Berhasil Mengupload Foto Profile');
            } else {
                $img_id = $user_id . '.' . 'png';
                $user->profile = $img_id;
                $user_img->storeAs('profile', $img_id);
                $user->update();
                return redirect('/Home/User/Profile')->with('success', 'Berhasil Mengupload Foto Profile');
            }
        } else {
            return back()->with('warning', 'Mohon Upload File Terlebih Dahulu');
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function addPendidikan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tingkat' => 'required',
            'nama_instansi' => 'required',
            'tahun_lulus' => 'required',
        ]);

        if ($validator) {
            $pendidikan = new Pendidikan;
            $pendidikan->tingkat = $request->input('tingkat');
            $pendidikan->nama_instansi = $request->input('nama_instansi');
            $pendidikan->tahun_lulus = $request->input('tahun_lulus');
            $pendidikan->user_id = Auth::user()->id;
            $pendidikan->save();
            return redirect('/Home/User/Pendidikan')->with('success', 'Berhasil Menambah Pendidikan');
        }
    }

    public function lokerIndex()
    {
        return view('user.loker.loker');
    }

    public function renderLoker()
    {
        $loker = view('component.loker-render')->render();
        return response()->json(array(
            'loker' => $loker
        ));
    }

    public function addSertifikat(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'bidang_sertifikat' => 'required',
            'level' => 'required|min:0|max:9',
            'nomor' => 'required',
            'lembaga_sertifikasi' => 'required',
            'judul_sertifikasi' => 'required',
        ]);

        if ($validate) {
            $sertifikat = new Sertifikasi;
            $sertifikat->bidang_sertifikasi = $request->input('bidang_sertifikat');
            $sertifikat->level = $request->input('level');
            $sertifikat->nomor = $request->input('nomor');
            $sertifikat->lembaga_sertifikasi = $request->input('lembaga_sertifikat');
            $sertifikat->judul_sertifikasi = $request->input('judul_sertifikasi');
            $sertifikat->user_id = Auth::user()->id;
            $sertifikat->save();
            return back()->with('success', 'Berhasil Menambah Sertikat');
        }
    }

    public function addPengalaman(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_perusahaan' => 'required',
            'jabatan' => 'required',
            'tahun_masuk' => 'required',
            'tahun_keluar' => 'required',
        ]);

        if ($validate) {
            $pengalaman = new Pengalaman;
            $pengalaman->nama_perusahaan = $request->input('nama_perusahaan');
            $pengalaman->jabatan = $request->input('jabatan');
            $pengalaman->tahun_masuk = $request->input('tahun_masuk');
            $pengalaman->tahun_keluar = $request->input('tahun_keluar');
            $pengalaman->user_id = Auth::user()->id;
            $pengalaman->save();
            return back()->with('success', 'Berhasil Menambah Data Pengalaman');
        }
    }


    public function indexResume()
    {
        $user_id = Auth::user()->id;
        $user = User::findOrfail($user_id);
        $resume = data_get($user, 'resume');
        return view('user.resume.index', compact('user'));
    }

    public function updateResume(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::findOrfail($user_id);
        $resume = data_get($user, 'resume');
        $user_resume = $request->file('resume');
        $validate = Validator::make($request->all(), [
            'resume' => 'required|mimes:pdf|max:10000',
        ]);
        if ($validate) {
            if (Storage::fileExists('/public/resume/' . $resume)) {
                Storage::delete('/public/resume/' . $resume);
                $resume_id = $user_id . '.' . $user_resume->extension();
                $user_resume->storeAs('resume', $resume_id);
                $user->resume = $resume_id;
                $user->update();
                return back()->with('success', 'Berhasil Menambah Resume');
            } else {
                $resume_id = $user_id . '.' . 'pdf';
                $user->resume = $resume_id;
                $user_resume->storeAs('resume', $resume_id);
                $user->update();
                return back()->with('success', 'Resume berhasil di tambahkan');
            }
        } else {
            return back()->with('warning', 'Mohon Upload Kembali Resume');
        }
    }

    public function indexApplication()
    {
        $user_id = Auth::user()->id;
        $application = Application::where('user_id', '=', $user_id)->with('loker')->get();
        return view('user.application.index', compact('application'));
    }

    public function submitApplication($id)
    {
        $user_id = Auth::user()->id;
        $user_data = User::findOrfail($user_id);
        $resume = data_get($user_data, 'resume');
        $profile = data_get($user_data, 'profile');
        $loker = Loker::findorfail($id);
        $loker_id = data_get($loker, 'id');
        if (Application::where('user_id', '=', $user_id)->where('loker_id', '=', $loker_id)->first()) {
            return back()->with('warning', 'Lamaran Sudah Dimasukkan');
        } else {
            if ($profile == null && $resume == null) {
                return back()->with('warning', 'Lengkapi Terlebih Dahulu Data Profile');
            } else {
                $application = new Application;
                $application->user_id = $user_id;
                $application->loker_id = $id;
                $application->status = 'pending';
                $application->save();
                return back()->with('success', 'Lamaran Telah Dimasukkan');
            }
        }
    }

    public function indexAppointment()
    {
        $user_id = Auth::user()->id;
        $appointment = Appointment::where('user_id', '=', $user_id)->get();
        return view('user.consult.index', compact('appointment'));
    }

    public function AppointmentForm()
    {
        return view('user.consult.form');
    }

    public function createAppointment(Request $request)
    {
        $user_id = Auth::user()->id;
        $validate = Validator::make($request->all(), [
            'topik' => 'required',
            'jenis_konseling' => 'required',
            'tanggal_konseling' => 'required',
            'jam_konseling' => 'required',
        ]);

        if ($validate) {
            $date = $request->input('tanggal_konseling');
            $jam = $request->input('jam_konseling');
            $merge = new DateTime($date . ' ' . $jam);
            $appointment = new Appointment;
            $appointment->user_id = $user_id;
            $appointment->date_time = $merge;
            $appointment->color = '#ffc107';
            $appointment->topik = $request->input('topik');
            $appointment->jenis_konseling = $request->input('jenis_konseling');
            $appointment->status = 'Pending';
            if (Appointment::where('date_time', '=', $merge)->exists()) {
                return back()->with('warning', 'Tanggal dan Jam Sudah Penuh Mohon Mengganti Jadwal');
            } else {
                $appointment->save();
                return back()->with('success', 'Berhasil Membuat Jadwal Konseling, Menunggu Konfirmasi dari Admin');
            }
        } else {
            return back()->with('warning', 'Mohon memasukkan ulang form');
        }
    }
}
