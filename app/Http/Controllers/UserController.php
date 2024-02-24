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
        $topik = Topic::get();
        return view('user.index', compact('user', 'years', 'prodi', 'topik'));
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::findOrfail($id);
        if (!$user) {
            return back()->with('warning', 'User Tidak Ditemukan');
        }

        $rule = [
            'nama_lengkap' => 'required|string|min:4|max:100',
            'nomor_telepon' => 'required|numeric|digits:14',
            'tempat_lahir' => 'required|string|min:5|max:100',
            'tanggal_lahir' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'kewarganegaraan' => 'required|string',
            'jenis_kelamin' => 'required|string|in:pria,wanita',
            'agama' => 'required|string',
            'alamat' => 'required|string|min:10|max:255',
            'kota' => 'required|string|min:4|max:100',
            'kode_pos' => 'required|numeric',
            'program_studi' => 'nullable|string',
            'nim' => 'nullable',
            'ipk' => 'nullable|numeric|between:0,4',
            'pendidikan_tertinggi' => 'required|string',
            'status_perkawinan' => 'required|string'
        ];
        if ($request->input('alamat_email') != $user->alamat_email) {
            $rule['alamat_email'] = 'required|email|unique:users,alamat_email';
        }
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Data Profile, Mohon Mengisi Ulang Data Dengan Benar');
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
        if ($request->input('alamat_email') != $user->alamat_email) {
            $newEmail = $request->input('alamat_email');
            $user->email_verification = null;
            $user->alamat_email = $newEmail;

            $tokenRecord = DB::table('tokens')
                ->where('user_id', $user->id)
                ->where('category', 'user')
                ->where('type', 'email_verification')->first();

            if ($tokenRecord) {
                $token = $tokenRecord->token;
            } else {
                $tokenExists  = true;
                $token = null;
                while ($tokenExists) {
                    $token = Str::random(64);
                    $existingToken = DB::table('tokens')->where('token', $token)->first();
                    if (!$existingToken) {
                        $tokenExists = false;
                    }
                }

                DB::table('tokens')->insert([
                    'user_id' => $user->id,
                    'category' => 'user',
                    'token' => $token,
                    'type' => 'email_verification',
                    'expires_at' => now()->addMinutes(15),
                ]);
            }
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

        $validate = $request->validate([
            'profile_img' => 'required|ffile|mimes:png,jpeg|max:2048'
        ]);

        if ($validate) {
            $img_id = $user_id . '.' . $user_img->extension();

            if (Storage::exists("/public/profile/{$profileImg}")) {
                Storage::delete("/public/profile/{$profileImg}");
            }
            $user_img->storeAs('profile', $img_id);
            $user->update(['profile' => $img_id]);
            return redirect(route('user.index'))->with('success', 'Berhasil Mengubah Foto Profile');
        } else {
            return back()->with('warning', 'Mohon Memasukkan Ulang Foto Profile Dengan Benar dan Format PNG');
        }
    }

    public function addSertifikat(Request $request)
    {
        $rule = [
            'title' => 'required|string|min:3|max:100',
            'organisasi' => 'required|string|min:4|max:100',
            'bulan_terbit' => 'required',
            'tahun_terbit' => 'required',
            'id_sertifikat' => 'nullable|string',
            'url_sertifikat' => 'nullable|url',
        ];

        if ($request->filled('bulan_berakhir') || $request->filled('tahun_berakhir')) {
            $rule['bulan_berakhir'] = 'required|numeric|min:1|max:12';
            $rule['tahun_berakhir'] = 'required|numeric|min:' . date('Y');
        }

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return back()->with('warning', 'Mohon Mengisi Ulang Form Menambahkan Sertifikat Dengan Benar');
        }
        $formatDate = function ($bulan, $tahun) {
            $format_date = '01-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . $tahun;
            $dateTime =  DateTime::createFromFormat('d-m-Y', $format_date);
            return $dateTime->format('F Y');
        };

        $sertifikat = new Sertifikasi;
        $sertifikat->title = $request->input('title');
        $sertifikat->organisasi = $request->input('organisasi');
        $sertifikat->tanggal_terbit = $formatDate($request->input('bulan_terbit'), $request->input('tahun_terbit'));
        if ($request->filled('bulan_berakhir') & $request->filled('tahun_berakhir')) {
            $sertifikat->tanggal_berakhir = $formatDate($request->input('bulan_berakhir'), $request->input('tahun_berakhir'));
        }
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
            'title_sertifikat' => 'required|string|min:4|max:100',
            'organisasi' => 'required|string|min:4|max:100',
            'bulan_terbit' => 'required',
            'tahun_terbit' => 'required',
            'bulan_berakhir' => 'required_with_all:tahun_berakhir',
            'tahun_berakhir' => 'required_with_all:bulan_berakhir',
            'id_sertifikat' => 'nullable|string',
            'url_sertifikat' => 'nullable|url',
        ]);

        if ($validation->fails()) {
            return back()->with('warning', 'Mohon Mengisi Ulang Form dengan Benar');
        }
        $sertifikat->title = $request->input('title_sertifikat');
        $sertifikat->organisasi = $request->input('organisasi');
        $released_date = '01-' . str_pad($request->input('bulan_terbit'), 2, '0', STR_PAD_LEFT) . '-' . $request->input('tahun_terbit');
        $format_released_date = DateTime::createFromFormat('d-m-Y', $released_date);
        $tanggal_terbit = $format_released_date->format('F Y');
        $sertifikat->tanggal_terbit = $tanggal_terbit;
        if (!empty($request->input('bulan_berakhir')) && !empty($request->input('tahun_berakhir'))) {
            $end_date = '01-' . str_pad($request->input('bulan_berakhir'), 2, '0', STR_PAD_LEFT) . '-' . $request->input('berakhir');
            $format_end_date = DateTime::createFromFormat('d-m-Y', $end_date);
            $tanggal_berakhir = $format_end_date->format('F Y');
            $sertifikat->tanggal_berakhir = $tanggal_berakhir;
        }
        $sertifikat->id_sertifikat = $request->input('id_sertifikat');
        $sertifikat->url_sertifikat = $request->input('url_sertifikat');
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
            'nama_sekolah' => 'required|string|max:255',
            'tingkat_pendidikan' => 'required|string|max:50',
            'bidang_studi' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string|max:500',
            'tahun_lulus' => 'required|integer|min:1990|max:' . date('Y'),
            'keterangan' => 'nullable|string|max:500'
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            dd($validate->errors());
            return back()->with('warning', 'Mohon Mengisi Ulang Form Menambah Pendidikan');
        }

        $pendidikan = new Pendidikan;
        $pendidikan->nama_sekolah = $request->input('nama_sekolah');
        $pendidikan->tingkat_pendidikan = $request->input('tingkat_pendidikan');
        $pendidikan->bidang_studi = $request->input('bidang_studi');
        $pendidikan->tahun_lulus = $request->input('tahun_lulus');
        $pendidikan->alamat_sekolah = $request->input('alamat_sekolah');
        $pendidikan->keterangan = $request->input('keterangan');
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
            'nama_sekolah' => 'required|string|max:255',
            'tingkat_pendidikan' => 'required|string|max:50',
            'bidang_studi' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string|max:500',
            'tahun_lulus' => 'required|integer|min:1990|max:' . date('Y'),
            'keterangan' => 'nullable|string|max:500'
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return back()->with('warning', 'Mohon Mengisi Ulang Form Mengubah Data Pendidikan');
        }

        $pendidikan->nama_sekolah = $request->input('nama_sekolah');
        $pendidikan->tingkat_pendidikan = $request->input('tingkat_pendidikan');
        $pendidikan->bidang_studi = $request->input('bidang_studi');
        $pendidikan->alamat_sekolah = $request->input('alamat_sekolah');
        $pendidikan->tahun_lulus = $request->input('tahun_lulus');
        $pendidikan->keterangan = $request->input('keterangan');
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
            'title' => 'required|string|min:4|max:100',
            'jenis_pekerjaan' => 'required|string',
            'organisasi' => 'required|string|min:4|max:100',
            'lokasi_pekerjaan' => 'required|string|min:4|max:255',
            'bulan_mulai' => 'required',
            'tahun_mulai' => 'required',
            'deskripsi_pengalaman' => 'nullable|min:50|max:1000',
        ];

        if ($request->has('present_box')) {
            $rules['bulan_selesai'] = 'nullable';
            $rules['tahun_selesai'] = 'nullable';
        }
        if ($request->filled('bulan_selesai') || $request->filled('tahun_selesai')) {
            $rules['bulan_selesai'] = 'required';
            $rules['tahun_selesai'] = 'required';
        }

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            dd($validate->errors());
            return back()->with('warning', 'Mohon Mengisi Ulang Form Menambah Pengalaman Dengan Benar');
        }

        $formatDate = function ($bulan, $tahun) {
            $format_date = '01-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . $tahun;
            $dateTime =  DateTime::createFromFormat('d-m-Y', $format_date);
            return $dateTime->format('F Y');
        };

        $pengalaman = new Pengalaman;
        $pengalaman->title = $request->input('title');
        $pengalaman->jenis_pekerjaan = $request->input('jenis_pekerjaan');
        $pengalaman->organisasi = $request->input('organisasi');
        $pengalaman->lokasi_pekerjaan = $request->input('lokasi_pekerjaan');
        $pengalaman->tanggal_mulai = $formatDate($request->input('bulan_mulai'), $request->input('tahun_mulai'));
        if ($request->filled(['bulan_selesai', 'tahun_selesai'])) {
            $pengalaman->tanggal_selesai = $formatDate($request->input('bulan_selesai'), $request->input('tahun_selesai'));
        }
        $pengalaman->deskripsi = $request->input('deskripsi_pengalaman');
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
            return back()->with('warning', 'Data Pengalaman Tidak Ditemukan');
        }
        $rules = [
            'title' => 'required|string|min:4|max:100',
            'jenis_pekerjaan' => 'required|string',
            'organisasi' => 'required|string|min:4|max:100',
            'lokasi_pekerjaan' => 'required|string|min:10|max:100',
            'bulan_mulai' => 'required',
            'tahun_mulai' => 'required',
            'deskripsi_pengalaman' => 'nullable|string|min:50|max:1000',
        ];
        if ($request->has('present_box')) {
            $rules['bulan_selesai'] = 'nullable';
            $rules['tahun_selesai'] = 'nullable';
        }
        if ($request->filled('bulan_selesai') || $request->filled('tahun_selesai')) {
            $rules['bulan_selesai'] = 'required';
            $rules['tahun_selesai'] = 'required';
        }

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return back()->with('warning', 'Mohon Mengisi Ulang Form Menambah Pengalaman Dengan Benar');
        }

        $formatDate = function ($bulan, $tahun) {
            $format_date = '01-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . $tahun;
            $dateTime =  DateTime::createFromFormat('d-m-Y', $format_date);
            return $dateTime->format('F Y');
        };
        $pengalaman->title = $request->input('title');
        $pengalaman->jenis_pekerjaan = $request->input('jenis_pekerjaan');
        $pengalaman->organisasi = $request->input('organisasi');
        $pengalaman->lokasi_pekerjaan = $request->input('lokasi_pekerjaan');
        $pengalaman->tanggal_mulai = $formatDate($request->input('bulan_mulai'), $request->input('tahun_mulai'));
        if ($request->filled(['bulan_selesai', 'tahun_selesai'])) {
            $pengalaman->tanggal_selesai = $formatDate($request->input('bulan_selesai'), $request->input('tahun_selesai'));
        }
        $pengalaman->deskripsi = $request->input('deskripsi_pengalaman');
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

        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:2048',
        ]);

        if (Storage::exists('/public/resume/' . $resume)) {
            Storage::delete('/public/resume/' . $resume);
        }

        $resume_id = $user_id . '.' . $user_resume->extension();
        $user_resume->storeAs('resume', $resume_id);

        $user->update(['resume' => $resume_id]);

        return back()->with('success', 'Berhasil Mengupload Resume Baru');
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
        if ($request->input('google_meet') === 'Online') {
            $rule['google_meet'] = 'required|url|min:10|max:100';
        }

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {
            return back()->with('warning', 'Mohon Memasukkan Ulang Form');
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
        $appointment->status = 'on process';
        $appointment->google_meet = "-";
        if (Appointment::where('date_time', '=', $merge)->exists()) {
            return back()->with('warning', 'Tanggal dan Jam Sudah Terisi Mohon Mengganti Jadwal');
        } else {
            $appointment->save();
            return redirect(route('user.index'))->with('success', 'Jadwal konseling berhasil dibuat, mohon menunggu konfirmasi email dari pusat karir ITK, Terimakasih');
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
        $appointments = $user->appointment;
        $appointment = $appointments->firstWhere('id', $id);
        if ($appointment) {
            $rule = [
                'tempat_konseling' => 'required|string',
                'jam_konseling' => 'required',
                'tanggal_konseling' => 'required',
            ];

            if ($request->input('tempat_konseling') === 'Online') {
                $rule['google_meet'] = 'required|url|min:10|max:100';
            }

            $validate = Validator::make($request->all(), $rule);

            if ($validate->fails()) {
                return back()->with('warning', 'Gagal Mengubah Data Appointment, Masukkan Ulang Data Dengan Benar');
            }
            $appointment->tempat_konseling = $request->input('tempat_konseling');
            if ($request->filled('google_meet')) {
                $appointment->google_meet = $request->input('google_meet');
            }
            $date = $request->input('tanggal_konseling');
            $jam = $request->input('jam_konseling');
            $merge = new DateTime($date . ' ' . $jam);
            $appointment->date_time = $merge;
            $appointment->status = 'on process';
            if ($appointment->status === 'reschedule') {
                $appointment->update();
            } else {
                return back()->with('warning', 'Appointment Sedang Dalam Status Pending, Mohon Menunggu Respon Admin');
            }
            return back()->with('success', 'Berhasil Mengubah Waktu dan Tanggal Appointment');
        } else {
            return back()->with('warning', 'Gagal Menemukan Appointment');
        }
    }
}
