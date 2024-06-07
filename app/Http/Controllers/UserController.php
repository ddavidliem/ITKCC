<?php

namespace App\Http\Controllers;

use App\Models\Pendidikan;
use App\Models\Pengalaman;
use App\Models\Sertifikasi;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Topic;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DateTime;
use App\Models\Application;
use App\Models\Loker;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function guard()
    {
        $this->middleware('user');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function index()
    {
        $id = Auth::user()->id;
        $user = User::findOrfail($id);
        $user->load([
            'pengalaman' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'sertifikat' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'applications.loker.employer' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'appointment' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'pendidikan' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ]);
        $year = date('Y');
        $minYear = $year - 15;
        $maxYear = $year + 5;
        $years = range($minYear, $maxYear);
        $prodi = Prodi::get();
        $topik = Topic::where('status', 'enable')->get();
        $appointment = Appointment::with('user')->orderBy('created_at', 'DESC')->get();
        return view('user.index', compact('user', 'years', 'prodi', 'topik', 'appointment'));
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::findOrfail($id);
        if (!$user) {
            return back()->with('warning', 'User Tidak Ditemukan');
        }

        $rule = [
            'nama_lengkap' => 'required|string|min:4|max:128',
            'nomor_telepon' => 'required|digits_between:10,16',
            'tempat_lahir' => 'required|string|min:4|max:64',
            'tanggal_lahir' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'kewarganegaraan' => 'required|string|max:8',
            'jenis_kelamin' => 'required|string|in:pria,wanita',
            'agama' => 'required|string',
            'alamat' => 'required|string|min:8|max:512',
            'kota' => 'required|string|min:4|max:64',
            'kode_pos' => 'required|digits:6',
            'program_studi' => 'nullable|string|max:32',
            'nim' => 'nullable|unique:users,nim',
            'ipk' => 'nullable|numeric|between:0,4',
            'pendidikan_tertinggi' => 'required|string',
            'status_perkawinan' => 'required|string'
        ];
        if ($request->input('alamat_email') !== $user->alamat_email) {
            $rule['alamat_email'] = 'required|email|unique:users,alamat_email|regex:/@gmail\.com$/i';
        }
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput()->with('modal', 'editProfile');
        }
        $user->nama_lengkap = $request->input('nama_lengkap');
        $user->nomor_telepon = $request->input('nomor_telepon');
        $user->tempat_lahir = $request->input('tempat_lahir');
        $user->tanggal_lahir = $request->input('tanggal_lahir');
        $user->kewarganegaraan = $request->input('kewarganegaraan');
        $user->jenis_kelamin = $request->input('jenis_kelamin');
        $user->agama = $request->input('agama');
        $user->alamat = $request->input('alamat');
        $user->kota = $request->input('kota');
        $user->kode_pos = $request->input('kode_pos');
        $user->program_studi = $request->input('program_studi');
        $user->nim = $request->input('nim');
        $user->ipk = $request->input('ipk');
        $user->pendidikan_tertinggi = $request->input('pendidikan_tertinggi');
        $user->status_perkawinan = $request->input('status_perkawinan');
        if ($request->input('alamat_email') !== $user->alamat_email) {
            $newEmail = $request->input('alamat_email');
            $user->email_verification = null;
            $user->alamat_email = $newEmail;

            DB::table('tokens')->where('user_id', $user->id)
                ->where('category', 'user')
                ->where('type', 'email_verification')
                ->delete();

            $token = Str::random(64);

            DB::table('tokens')->insert([
                'user_id' => $user->id,
                'alamat_email' => $newEmail,
                'category' => 'user',
                'token' => $token,
                'type' => 'email_verification',
                'expires_at' => now()->addMinutes(15),
            ]);

            Mail::to($newEmail)->send(new EmailVerification($user, $token));
        }
        $user->update();
        return back()->with('success', 'Berhasil Mengubah Data Profile');
    }

    public function imgProfile(Request $request)
    {
        $auth = Auth::user();
        $user_id = $auth->id;
        $user = User::findOrfail($user_id);
        $profileImg = data_get($user, 'profile');
        $user_img = $request->file('profile_img');

        $validate = Validator::make($request->all(), [
            'profile_img' => 'required|file|mimes:png,jpeg|max:2048',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'updateProfileImg');
        }
        $img_id = $user_id . '.' . $user_img->extension();

        if (Storage::exists("/public/profile/{$profileImg}")) {
            Storage::delete("/public/profile/{$profileImg}");
        }
        $user_img->storeAs('profile', $img_id);
        $user->update(['profile' => $img_id]);
        return redirect(route('user.index'))->with('success', 'Berhasil Mengubah Foto Profile');
    }

    public function addSertifikat(Request $request)
    {
        $rule = [
            'title_sertifikat' => 'required|string|min:8|max:64',
            'organisasi_sertifikat' => 'required|string|min:8|max:64',
            'bulan_terbit_sertifikat' => 'required|digits_between:1,2|min:1|max:12',
            'tahun_terbit_sertifikat' => 'required|digits:4',
            'id_sertifikat' => 'nullable|string|min:4|max:128',
            'url_sertifikat' => 'nullable|string|min:4|max:128',
        ];

        if ($request->filled('bulan_berakhir_sertifikat') || $request->filled('tahun_berakhir_sertifikat')) {
            $rule['bulan_berakhir_sertifikat'] = 'required|digits_between:1,2|min:1|max:12';
            $rule['tahun_berakhir_sertifikat'] = 'required|digits:4|gte:' . $request->input('tahun_terbit_sertifikat');
        }

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'newSertifikat');
        }
        $formatDate = function ($bulan, $tahun) {
            $format_date = '01-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . $tahun;
            $dateTime =  DateTime::createFromFormat('d-m-Y', $format_date);
            return $dateTime->format('F Y');
        };

        $sertifikat = new Sertifikasi;
        $sertifikat->title = $request->input('title_sertifikat');
        $sertifikat->organisasi = $request->input('organisasi_sertifikat');
        $sertifikat->tanggal_terbit = $formatDate($request->input('bulan_terbit_sertifikat'), $request->input('tahun_terbit_sertifikat'));
        if ($request->filled('bulan_berakhir_sertifikat') & $request->filled('tahun_berakhir_sertifikat')) {
            $sertifikat->tanggal_berakhir = $formatDate($request->input('bulan_berakhir_sertifikat'), $request->input('tahun_berakhir_sertifikat'));
        }
        $sertifikat->id_sertifikat = $request->input('id_sertifikat');
        $sertifikat->url_sertifikat = $request->input('url_sertifikat');
        $sertifikat->user_id = Auth::user()->id;
        $sertifikat->save();
        return back()->with('success', 'Berhasil Menambahkan Sertifikat');
    }

    public function detailSertifikat($id)
    {
        $sertifikat = Auth::user()->sertifikat->find($id);
        if (!$sertifikat) {
            return response()->json(['error' => 'Sertifikat Tidak Ditemukan'], 404);
        }
        return response()->json($sertifikat);
    }

    public function updateSertifikat(Request $request, $id)
    {
        $sertifikat = Auth::user()->sertifikat->find($id);
        if (!$sertifikat) {
            return back()->with('warning', 'Gagal Mengubah Data Sertifikat');
        }
        $validation = Validator::make($request->all(), [
            'title_sertifikat_edit' => 'required|string|min:4|max:64',
            'organisasi_sertifikat_edit' => 'required|string|min:4|max:64',
            'bulan_terbit_sertifikat_edit' => 'required|digits_between:1,2|min:1|max:12',
            'tahun_terbit_sertifikat_edit' => 'required|digits:4',
            'bulan_berakhir_sertifikat_edit' => 'required_with:tahun_berakhir|digits_between:1,2|min:1|max:12',
            'tahun_berakhir_sertifikat_edit' => 'required_with:bulan_berakhir|digits:4',
            'id_sertifikat_edit' => 'nullable|string|min:4|max:128',
            'url_sertifikat_edit' => 'nullable|url|min:4|max:128',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->with('modal', 'editSertifikat');
        }

        $sertifikat->title = $request->input('title_sertifikat_edit');
        $sertifikat->organisasi = $request->input('organisasi_sertifikat_edit');
        $released_date = '01-' . str_pad($request->input('bulan_terbit_sertifikat_edit'), 2, '0', STR_PAD_LEFT) . '-' . $request->input('tahun_terbit_sertifikat_edit');
        $format_released_date = DateTime::createFromFormat('d-m-Y', $released_date);
        $tanggal_terbit = $format_released_date->format('F Y');
        $sertifikat->tanggal_terbit = $tanggal_terbit;
        if (!empty($request->input('bulan_berakhir_sertifikat_edit')) && !empty($request->input('tahun_berakhir_sertifikat_edit'))) {
            $end_date = '01-' . str_pad($request->input('bulan_berakhir_sertifikat_edit'), 2, '0', STR_PAD_LEFT) . '-' . $request->input('tahun_berakhir_sertifikat_edit');
            $format_end_date = DateTime::createFromFormat('d-m-Y', $end_date);
            $tanggal_berakhir = $format_end_date->format('F Y');
            $sertifikat->tanggal_berakhir = $tanggal_berakhir;
        } else {
            $sertifikat->tanggal_berakhir = null;
        }
        $sertifikat->id_sertifikat = $request->input('id_sertifikat_edit');
        $sertifikat->url_sertifikat = $request->input('url_sertifikat_edit');
        $sertifikat->user_id = Auth::user()->id;
        $sertifikat->update();
        return back()->with('success', 'Berhasil Mengubah Data Sertifikat');
    }

    public function deleteSertifikat($id)
    {
        $sertifikat = Auth::user()->sertifikat->find($id);
        if (!$sertifikat) {
            return back()->with('warning', 'Gagal Menghapus Sertifikat');
        }
        $sertifikat->delete();
        return back()->with('success', 'Berhasil Menghapus Sertifikat');
    }

    public function addPendidikan(Request $request)
    {
        $rules = [
            'nama_sekolah' => 'required|string|min:4|max:128',
            'tingkat_pendidikan' => 'required|string|min:2|max:32',
            'bidang_studi' => 'required|string|min:2|max:64',
            'alamat_sekolah' => 'required|string|max:256',
            'tahun_lulus' => 'required|integer|digits:4|min:1990|max:' . date('Y'),
            'keterangan_pendidikan' => 'nullable|string|max:512'
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'newPendidikan');
        }

        $pendidikan = new Pendidikan;
        $pendidikan->nama_sekolah = $request->input('nama_sekolah');
        $pendidikan->tingkat_pendidikan = $request->input('tingkat_pendidikan');
        $pendidikan->bidang_studi = $request->input('bidang_studi');
        $pendidikan->tahun_lulus = $request->input('tahun_lulus');
        $pendidikan->alamat_sekolah = $request->input('alamat_sekolah');
        $pendidikan->keterangan = $request->input('keterangan_pendidikan');
        $pendidikan->user_id = Auth::user()->id;
        $pendidikan->save();
        return back()->with('success', 'Berhasil Menambah Data Pendidikan');
    }

    public function detailPendidikan($id)
    {
        $pendidikan = Auth::user()->pendidikan->find($id);
        if (!$pendidikan) {
            return response()->json(['error' => 'Data Pendidikan Tidak Ditemukan'], 404);
        }
        return response()->json($pendidikan);
    }


    public function updatePendidikan(Request $request, $id)
    {
        $pendidikan = Auth::user()->pendidikan->find($id);
        if (!$pendidikan) {
            return back()->with('warning', 'Data Pendidikan Tidak Ditemukan');
        }
        $rules = [
            'nama_sekolah_edit' => 'required|string|max:128',
            'tingkat_pendidikan_edit' => 'required|string|min:2|max:32',
            'bidang_studi_edit' => 'required|string|min:2|max:64',
            'alamat_sekolah_edit' => 'required|string|max:256',
            'tahun_lulus_edit' => 'required|integer|digits:4|min:1990|max:' . date('Y'),
            'keterangan_pendidikan_edit' => 'nullable|string|max:512'
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'editPendidikan');
        }

        $pendidikan->nama_sekolah = $request->input('nama_sekolah_edit');
        $pendidikan->tingkat_pendidikan = $request->input('tingkat_pendidikan_edit');
        $pendidikan->bidang_studi = $request->input('bidang_studi_edit');
        $pendidikan->alamat_sekolah = $request->input('alamat_sekolah_edit');
        $pendidikan->tahun_lulus = $request->input('tahun_lulus_edit');
        $pendidikan->keterangan = $request->input('keterangan_pendidikan_edit');
        $pendidikan->update();

        return back()->with('success', 'Berhasil Mengubah Data Pendidikan');
    }

    public function deletePendidikan($id)
    {
        $pendidikan = Auth::user()->pendidikan->find($id);
        if (!$pendidikan) {
            return back()->with('warning', 'Data Pendidikan Tidak Ditemukan');
        }
        $pendidikan->delete();
        return back()->with('success', 'Berhasil Menghapus Data Pendidikan');
    }

    public function addPengalaman(Request $request)
    {
        $rules = [
            'title_pengalaman_kerja' => 'required|string|min:4|max:128',
            'organisasi_pengalaman_kerja' => 'required|string|min:4|max:128',
            'lokasi_pekerjaan_pengalaman_kerja' => 'required|string|min:4|max:256',
            'bulan_mulai_pengalaman_kerja' => 'required|digits_between:1,2|min:1|max:12',
            'tahun_mulai_pengalaman_kerja' => 'required|digits:4',
            'deskripsi_pengalaman_kerja' => 'nullable|min:50|max:512',
        ];

        if ($request->has('present_box')) {
            $rules['bulan_selesai_pengalaman_kerja'] = 'nullable|digits_between:1,2|min:1|max:12';
            $rules['tahun_selesai_pengalaman_kerja'] = 'nullable|digits:4|gte:' . $request->input('tahun_mulai_pengalaman_kerja');
        }
        if ($request->filled('bulan_selesai_pengalaman_kerja') || $request->filled('tahun_selesai_pengalaman_kerja')) {
            $rules['bulan_selesai_pengalaman_kerja'] = 'required|digits_between:1,2|min:1|max:12';
            $rules['tahun_selesai_pengalaman_kerja'] = 'required|digits:4|gte:' . $request->input('tahun_mulai_pengalaman_kerja');
        }

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'newPengalaman');
        }

        $formatDate = function ($bulan, $tahun) {
            $format_date = '01-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . $tahun;
            $dateTime =  DateTime::createFromFormat('d-m-Y', $format_date);
            return $dateTime->format('F Y');
        };

        $pengalaman = new Pengalaman;
        $pengalaman->title = $request->input('title_pengalaman_kerja');
        $pengalaman->organisasi = $request->input('organisasi_pengalaman_kerja');
        $pengalaman->lokasi_pekerjaan = $request->input('lokasi_pekerjaan_pengalaman_kerja');
        $pengalaman->tanggal_mulai = $formatDate($request->input('bulan_mulai_pengalaman_kerja'), $request->input('tahun_mulai_pengalaman_kerja'));
        if ($request->filled(['bulan_selesai_pengalaman_kerja', 'tahun_selesai_pengalaman_kerja'])) {
            $pengalaman->tanggal_selesai = $formatDate($request->input('bulan_selesai_pengalaman_kerja'), $request->input('tahun_selesai_pengalaman_kerja'));
        }
        $pengalaman->deskripsi = $request->input('deskripsi_pengalaman_kerja');
        $pengalaman->user_id = Auth::user()->id;
        $pengalaman->save();

        return back()->with('success', 'Berhasil Menambah Data Pengalaman');
    }

    public function detailPengalaman($id)
    {
        $pengalaman = Auth::user()->pengalaman->find($id);
        if (!$pengalaman) {
            return response()->json(['error' => 'Data Pengalaman Kerja Tidak Ditemukan'], 404);
        }
        return response()->json($pengalaman);
    }

    public function updatePengalaman(Request $request, $id)
    {
        $pengalaman = Auth::user()->pengalaman->find($id);
        if (!$pengalaman) {
            return back()->with('warning', 'Data Pengalaman Kerja Tidak Ditemukan');
        }
        $rules = [
            'title_pengalaman_kerja_edit' => 'required|string|min:4|max:100',
            'organisasi_pengalaman_kerja_edit' => 'required|string|min:4|max:100',
            'lokasi_pekerjaan_pengalaman_kerja_edit' => 'required|string|min:10|max:100',
            'bulan_mulai_pengalaman_kerja_edit' => 'required|numeric|min:1|max:12',
            'tahun_mulai_pengalaman_kerja_edit' => 'required|digits:4',
            'deskripsi_pengalaman' => 'nullable|string|min:50|max:1000',
        ];
        if ($request->has('present_box')) {
            $rules['bulan_selesai_pengalaman_kerja_edit'] = 'nullable';
            $rules['tahun_selesai_pengalaman_kerja_edit'] = 'nullable';
        }
        if ($request->filled('bulan_selesai_pengalaman_kerja_edit') || $request->filled('tahun_selesai_pengalaman_kerja_edit')) {
            $rules['bulan_selesai_pengalaman_kerja_edit'] = 'required|numeric|min:1|max:12';
            $rules['tahun_selesai_pengalaman_kerja_edit'] = 'required|digits:4|gte:' . $request->input('tahun_selesai_pengalaman_kerja_edit');
        }

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'editPengalaman');
        }

        $formatDate = function ($bulan, $tahun) {
            $format_date = '01-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . $tahun;
            $dateTime =  DateTime::createFromFormat('d-m-Y', $format_date);
            return $dateTime->format('F Y');
        };
        $pengalaman->title = $request->input('title_pengalaman_kerja_edit');
        $pengalaman->organisasi = $request->input('organisasi_pengalaman_kerja_edit');
        $pengalaman->lokasi_pekerjaan = $request->input('lokasi_pekerjaan_pengalaman_kerja_edit');
        $pengalaman->tanggal_mulai = $formatDate($request->input('bulan_mulai_pengalaman_kerja_edit'), $request->input('tahun_mulai_pengalaman_kerja_edit'));
        if ($request->filled(['bulan_selesai_pengalaman_kerja_edit', 'tahun_selesai_pengalaman_kerja_edit'])) {
            $pengalaman->tanggal_selesai = $formatDate($request->input('bulan_selesai_pengalaman_kerja_edit'), $request->input('tahun_selesai_pengalaman_kerja_edit'));
        }
        $pengalaman->deskripsi = $request->input('deskripsi_pengalaman_kerja_edit');
        $pengalaman->user_id = Auth::user()->id;
        $pengalaman->update();

        return back()->with('success', 'Berhasil Mengubah Data Pengalaman Kerja');
    }

    public function deletePengalaman($id)
    {
        $pengalaman = Auth::user()->pengalaman->find($id);
        if (!$pengalaman) {
            return back()->with('warning', 'Gagal Menghapus Data Pengalaman');
        }
        $pengalaman->delete();
        return back()->with('success', 'Pengalaman Berhasil Di Hapus');
    }

    public function updateResume(Request $request)
    {
        $auth = Auth::user();
        $user_id = $auth->id;
        $user = User::findOrfail($user_id);
        $resume = data_get($user, 'resume');
        $user_resume = $request->file('resume');

        $validate = Validator::make($request->all(), [
            'resume' => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'userResume');
        }

        if (Storage::exists('/public/resume/' . $resume)) {
            Storage::delete('/public/resume/' . $resume);
        }

        $resume_id = $user_id . '.' . $user_resume->extension();
        $user_resume->storeAs('resume', $resume_id);

        $user->update(['resume' => $resume_id]);

        return back()->with('success', 'Berhasil Mengunggah Resume Baru');
    }

    public function indexApplication()
    {
        $user_id = Auth::user()->id;
        $application = Application::where('user_id', '=', $user_id)->with('loker')->get();
        return view('user.application.index', compact('application'));
    }

    public function detailApplication($id)
    {
        $user = Auth::User();
        if (!$user->applications->find($id)) {
            return back()->with('warning', 'Application Tidak Ditemukan');
        }
        $application = $user->applications->find($id);
        return view('user.application.detail', compact('application'));
    }

    public function submitApplication($id)
    {
        $user_id = Auth::user()->id;
        $user = User::findOrfail($user_id);
        $pending = $user->applications()->where('status', 'On Process')->count();
        if ($pending >= 5) {
            return back()->with('warning', 'Telah Mencapai Batas Untuk Memasukkan Lamaran, Mohon Menunggu Respon Dari Perusahaan');
        }
        $loker = Loker::findorfail($id);
        if ($user->email_verification == null) {
            return back()->with('warning', 'Mohon Melakukan Verifikasi Email Terlebih Dahulu');
        }
        if (!$user->profile || !$user->resume) {
            return back()->with('warning', 'Mohon Melengkapi Data Profile Terlebih Dahulu');
        }
        if ($loker->applicants()->where('user_id', $user_id)->exists()) {
            return back()->with('warning', 'Lamaran Sudah Dimasukkan');
        }
        if ($pending > 5) {
            return back()->with('warning', 'Telah Mencapai Batas Untuk Melakukan Pelamaran');
        }
        if ($loker->status == "Closed" && $loker->deadline >= now()) {
            return back()->with('warning', 'Lowongan Kerja Sudah Tidak Menerima Lamaran Kerja');
        }

        $application = new Application;
        $application->user_id = $user_id;
        $application->loker_id = $id;
        $application->status = 'on process';
        $application->nama_lengkap = $user->nama_lengkap;
        $application->alamat_email = $user->alamat_email;
        $application->nomor_telepon = $user->nomor_telepon;
        $application->tempat_lahir = $user->tempat_lahir;
        $application->tanggal_lahir = $user->tanggal_lahir;
        $application->kewarganegaraan = $user->kewarganegaraan;
        $application->jenis_kelamin = $user->jenis_kelamin;
        $application->agama = $user->agama;
        $application->alamat = $user->alamat;
        $application->kota = $user->kota;
        $application->kode_pos = $user->kode_pos;
        $application->program_studi = $user->program_studi;
        $application->nim = $user->nim;
        $application->ipk = $user->ipk;
        $application->pendidikan_tertinggi = $user->pendidikan_tertinggi;
        $application->status_perkawinan = $user->status_perkawinan;
        $application->save();
        return back()->with('success', 'Lamaran Telah Dimasukkan');
    }

    public function AppointmentForm()
    {
        $topik = Topic::get();
        return view('user.consult.form', compact('topik'));
    }

    public function createAppointment(Request $request)
    {
        $user_id = Auth::user()->id;
        if (Auth::user()->alamat_email === null) {
            return back()->with('warning', 'Mohon Melakukan Verifikasi Email Terlebih Dahulu');
        }
        $rule = [
            'topik' => 'required|string',
            'jenis_konseling' => 'required|string',
            'tanggal_konseling' => 'required|date|after_or_equal:today',
            'jam_konseling' => 'required',
            'tempat_konseling' => 'required|string',
        ];
        if ($request->input('jenis_konseling') === 'kelompok') {
            $rule['jumlah_peserta_konseling'] = 'required|numeric|min:1|max:5';
        }
        if ($request->input('google_meet') === 'Online') {
            $rule['google_meet'] = 'required|url|min:8|max:100';
        }


        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'newAppointment');
        }

        $date = $request->input('tanggal_konseling');
        $jam = $request->input('jam_konseling');
        $merge = new DateTime($date . ' ' . $jam);
        $appointment = new Appointment;
        $appointment->user_id = $user_id;
        $appointment->date_time = $merge;
        $appointment->topik = $request->input('topik');
        $appointment->jenis_konseling = $request->input('jenis_konseling');
        $appointment->tempat_konseling = $request->input('tempat_konseling');
        if ($request->filled('google_meet')) {
            $appointment->google_meet = $request->input('google_meet');
        }
        if ($request->filled('jumlah_peserta_konseling')) {
            $appointment->jumlah_peserta = $request->input('jumlah_peserta_konseling');
        }
        $appointment->status = 'on process';
        if (Appointment::where('date_time', '=', $merge)->exists()) {
            return back()->with(['warning' => 'Maaf, Tanggal dan Jam Konseling Sudah Terisi Mohon Mengganti Jadwal', 'modal' => 'newAppointment']);
        } else {
            $appointment->save();
            return redirect(route('user.index'))->with('success', 'Jadwal konseling berhasil dibuat, mohon menunggu persetujuan dari tim pusat karir ITK, Terimakasih');
        }
    }

    public function detailAppointment($id)
    {
        $appointment = Auth::user()->appointment->find($id);
        if (!$appointment) {
            return response()->json(['error' => 'Data Appointment Tidak Ditemukan'], 404);
        }
        return response()->json($appointment);
    }

    public function editAppointment(Request $request, $id)
    {
        $user = Auth::user();
        $appointment = $user->appointment->find($id);
        if (!$appointment || $appointment->status !== 'reschedule') {
            return back()->with('warning', 'Appointment sedang dalam proses oleh admin atau tidak ditemukan.');
        }
        $rule = [
            'tempat_konseling_edit' => 'required|string|in:Online,Offline',
            'jam_konseling_edit' => 'required',
            'tanggal_konseling_edit' => 'required',
        ];

        if ($request->input('tempat_konseling_edit') === 'Online') {
            $rule['google_meet_edit'] = 'required|url|min:8|max:64';
        }

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'updateAppointment');
        }

        $appointment->tempat_konseling = $request->input('tempat_konseling_edit');
        if ($request->filled('google_meet_edit')) {
            $appointment->google_meet = $request->input('google_meet_edit');
        }
        $date = $request->input('tanggal_konseling_edit');
        $jam = $request->input('jam_konseling_edit');
        $merge = new DateTime($date . ' ' . $jam);
        $appointment->date_time = $merge;
        $appointment->status = 'on process';
        $appointment->update();
        return back()->with('success', 'Berhasil Mengubah Waktu dan Tanggal Appointment');
    }
}
