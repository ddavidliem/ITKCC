<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Application;
use App\Models\Approval;
use App\Models\Loker;
use App\Models\User;
use App\Models\Employer;
use App\Models\Content;
use App\Models\Topic;
use App\Models\Prodi;
use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use DateTime;
use App\Mail\ApprovalNotification;
use App\Mail\AppointmentNotification;
use App\Mail\EmailVerification;

class AdminController extends Controller
{

    public function guard()
    {
        $this->middleware('admin');
    }
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login/admin/form');
    }

    function period($startDate, $endDate)
    {
        $period = [];
        while ($startDate <= $endDate) {
            $monthYear = $startDate->format('F Y');
            $start = $startDate->copy()->startOfMonth();
            $end = $startDate->copy()->endOfMonth();
            $period[] = [
                'label' => $monthYear,
                'start' => $start,
                'end' => $end
            ];
            $startDate->addMonth();
        }
        return $period;
    }

    function countData($period, $model)
    {
        $dataChartConfig = [
            'labels' => [],
            'data' => [],
        ];

        foreach ($period as $time) {
            $count = $model::whereBetween('created_at', [$time['start'], $time['end']])->count();
            $dataChartConfig['labels'][] = $time['label'];
            $dataChartConfig['data'][] = $count;
        }

        return $dataChartConfig;
    }

    public function getData($period, $model)
    {
        $dataConfig = [
            'labels' => [],
            'data' => [],
        ];

        $count = 0;
        foreach ($period as $time) {
            $label = $time['label'];
            $data = $model::whereBetween('created_at', [$time['start'], $time['end']])->count();
            $count += $data;

            $dataConfig['labels'][] = $label;
            $dataConfig['data'][] = $count;
        }

        $dataConfig['labels'] = array_slice($dataConfig['labels'], -6);
        $dataConfig['data'] = array_slice($dataConfig['data'], -6);

        return $dataConfig;
    }

    public function index()
    {
        $currentDate = Carbon::now();
        $endDate = Carbon::now()->endOfMonth();
        $startDate = $currentDate->copy()->subMonths(5)->startOfMonth();
        $period = $this->period($startDate, $endDate);
        $user = [
            'user_total' => User::count(),
            'user_notverify' => User::whereNull('email_verification')->count(),
            'user_itk' => User::whereNotNull('nim')->whereNotNull('email_verification')->count(),
            'user' => User::whereNull('nim')->whereNotNull('email_verification')->count(),
            'user_application' => User::with('applications')->has('applications')->count(),
            'user_nullApplication' => User::doesntHave('applications')->count(),
            'user_disability' => User::whereNotNull('disabilitas')->count(),
            'user_new' => User::whereBetween('created_at', [$currentDate->startOfMonth()->toDateString(), $currentDate->endOfMonth()->toDateString()])->whereNotNull('email_verification')->count(),
        ];
        $userData = $this->getData($period, User::class);

        $employer = [
            'total' => Employer::count(),
            'emailNull' => Employer::whereNull('email_verification')->count(),
            'new' => Employer::whereBetween('created_at', [$currentDate->startOfMonth()->toDateString(), $currentDate->endOfMonth()->toDateString()])->whereNotNull('email_verification')->count(),
        ];

        $employerData = $this->getData($period, Employer::class);

        $loker = [
            'total' => Loker::count(),
            'open' => Loker::where('status', 'open')->count(),
            'closed' => Loker::where('status', 'closed')->count(),
            'new' => Loker::whereBetween('created_at', [$currentDate->StartOfMonth()->toDateString(), $currentDate->EndOfMonth()->toDateString()])
        ];
        $lokerData = $this->getData($period, Loker::class);

        $approval = [
            'total' => Approval::count(),
            'approved' => Approval::where('status', 'accepted')->count(),
            'not_approved' => Approval::where('status', 'declined')->count(),
            'pending' => Approval::where('status', 'on process')->count(),
        ];
        $approvalData = $this->getData($period, Approval::class);

        $appointment = [
            'total' => Appointment::count(),
            'done' => Appointment::where('status', 'finished')->count(),
            'approved' => Appointment::where('status', 'accepted')->count(),
            'pending' => Appointment::where('status', 'on process')->count(),
            'week' => Appointment::whereBetween('created_at', [$currentDate->startOfWeek()->toDateString(), $currentDate->endOfWeek()->toDateString()])->where('status', 'approved')->count(),
        ];

        $appointmentData  = $this->getData($period, Appointment::class);
        return view('admin.index', compact(
            'user',
            'userData',
            'employer',
            'employerData',
            'loker',
            'lokerData',
            'approval',
            'approvalData',
            'appointment',
            'appointmentData'
        ));
    }

    public function approvalPage()
    {
        $currentDate = Carbon::now();
        $endDate = Carbon::now()->endOfMonth();
        $startDate = $currentDate->copy()->subMonths(5)->startOfMonth();

        $period = $this->period($startDate, $endDate);
        $approvalDataChart = $this->getData($period, Approval::class);
        $newApprovalChart = $this->countData($period, Approval::class);
        $all = Approval::get();
        $approval = [
            'total' => Approval::count(),
            'pending' => Approval::where('status', 'on process')->count(),
            'approved' => Approval::where('status', 'accepted')->count(),
            'not_approved' => Approval::where('status', 'declined')->count(),
            'new' => Approval::whereBetween('created_at', [$currentDate->startOfMonth()->toDateString(), $currentDate->endOfMonth()->toDateString()])->count(),
        ];
        return view('admin.approval.index', compact('approval', 'approvalDataChart', 'newApprovalChart', 'all'));
    }

    public function approvalDelete($id)
    {
        $approval = Approval::findOrfail($id);
        if (!$approval) {
            return back()->with('warning', ' Approval Permohonan Akun Perusahaan Tidak Ditemukan');
        }
        $approval->delete();

        return back()->with('success', 'Approval Akun Perusahaan Telah Di Hapus');
    }

    public function approvalUpdate(Request $request, $id)
    {
        $approval = Approval::findOrfail($id);
        if (!$approval) {
            return back()->with('warning', 'Nomor Approval Tidak Ditemukan');
        }
        $validate = Validator::make($request->all(), [
            'approval_status' => 'required|in:accepted,declined',
        ]);
        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Status Approval');
        }

        $approval->update(['status' => $request->input('approval_status')]);
        if ($approval->update === 'accepted') {
            $employer = new Employer;
            $employer->nama_perusahaan = $approval->nama_perusahaan;
            $employer->alamat = $approval->alamat;
            $employer->provinsi = $approval->provinsi;
            $employer->kota = $approval->kota;
            $employer->kode_pos = $approval->kode_pos;
            $employer->website = $approval->website;
            $employer->nama_lengkap = $approval->nama_lengkap;
            $employer->jabatan = $approval->jabatan;
            $employer->nomor_telepon = $approval->nomor_telepon;
            $employer->alamat_email = $approval->alamat_email;
            $employer->email_verification = null;
            $employer->save();
        }

        $template = 'approval';
        Mail::to($approval->alamat_email)->send(new ApprovalNotification($approval, $template));
        return back()->with('success', 'Berhasil Mengubah Status Approval');
    }

    public function employerIndex()
    {
        $currentDate = Carbon::now();
        $endDate = Carbon::now()->endOfMonth();
        $startDate = $currentDate->copy()->subMonths(5)->startOfMonth();

        $employer = [
            'all' => Employer::orderBy('created_at', 'DESC')->get(),
            'total' => Employer::whereNotNull('email_verification')->count(),
            'null' => Employer::whereNull('email_verification')->count(),
            'new' => Employer::whereBetween('created_at', [$currentDate->StartOfMonth()->toDateString(), $currentDate->EndOfMonth()->toDateString()]),
        ];
        $period = $this->period($startDate, $endDate);
        $employerTotal = $this->getData($period, Employer::class);
        $employerNew = $this->countData($period, Employer::class);
        return view('admin.employer.index', compact('employer', 'employerTotal', 'employerNew'));
    }

    public function employerDetail($id)
    {
        $employer = Employer::findOrfail($id);
        $loker = $employer->loker()->orderBy('created_at', 'DESC')->get();
        $endDate = Carbon::now()->endOfMonth();
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();
        $period = $this->period($startDate, $endDate);
        $applicants = $loker->map(function ($item) {
            return [
                'total_applicants' => $item->applicants->count(),
            ];
        });

        $employerDetail = [
            'total' => $applicants->sum('total_applicants'),
            'loker' => $loker,
        ];

        $tipeLoker = [
            'label' => $loker->pluck('tipe_pekerjaan')->unique()->values()->toArray(),
            'data' => [],
        ];

        foreach ($tipeLoker['label'] as $tipe) {
            $count = Loker::where('tipe_pekerjaan', $tipe)->count();
            $tipeLoker['data'][] = $count;
        }

        $jenisLoker = [
            'label' => $loker->pluck('jenis_pekerjaan')->unique()->values()->toArray(),
            'data' => [],
        ];

        foreach ($jenisLoker['label'] as $jenis) {
            $count = Loker::where('jenis_pekerjaan', $jenis)->count();
            $jenisLoker['data'][] = $count;
        }

        $totalLoker = [
            'labels' => [],
            'data' => [],
        ];

        $count = 0;
        foreach ($period as $time) {
            $label = $time['label'];
            $data = $loker->whereBetween('created_at', [$time['start'], $time['end']])->count();
            $count += $data;

            $totalLoker['labels'][] = $label;
            $totalLoker['data'][] = $count;
        }
        $totalLoker['labels'] = array_slice($totalLoker['labels'], -6);
        $totalLoker['data'] = array_slice($totalLoker['data'], -6);

        return view('admin.employer.detail', compact('employer', 'employerDetail', 'applicants', 'tipeLoker', 'jenisLoker', 'totalLoker'));
    }

    public function employerUpdate(Request $request, $id)
    {
        $employer = Employer::findOrfail($id);
        if (!$employer) {
            return back()->with('warning', 'Akun Perusahaan Tidak Ditemukan');
        }

        $rule = [
            'nama_perusahaan' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'kantor_pusat' => 'required',
            'website' => 'required',
            'bidang_perusahaan' => 'required',
            'tahun_berdiri' => 'required',
            'kode_pos' => 'required',
            'nama_employer' => 'required',
            'nomor_telepon' => 'required',
            'jabatan' => 'required'
        ];

        if ($request->input('alamat_email') != $employer->alamat_email) {
            $rule['alamat_email'] = 'required|unique:employers,alamat_email';
        }

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Data Akun Perusahaan, Mohon Mengisi Ulang Form Dengan Benar');
        }
        $employer->nama_perusahaan = $request->input('nama_perusahaan');
        $employer->alamat = $request->input('alamat');
        $employer->kota = $request->input('kota');
        $employer->provinsi = $request->input('provinsi');
        $employer->kantor_pusat = $request->input('kantor_pusat');
        $employer->website = $request->input('website');
        $employer->bidang_perusahaan = $request->input('bidang_perusahaan');
        $employer->tahun_berdiri = $request->input('tahun_berdiri');
        $employer->kode_pos = $request->input('kode_pos');
        $employer->nama_lengkap = $request->input('nama_employer');
        $employer->nomor_telepon = $request->input('nomor_telepon');
        $employer->jabatan = $request->input('jabatan');

        if ($request->input('alamat_email') != $employer->alamat_email) {
            $newEmail = $request->input('alamat_email');
            $employer->email_verification = null;
            $employer->alamat_email = $newEmail;

            $tokenRecord = DB::table('tokens')->where('user_id', $employer->id)
                ->where('category', 'employer')
                ->where('type', 'email_verification')
                ->first();

            if ($tokenRecord) {
                $token = $tokenRecord->token;
            } else {
                $tokenExists = true;
                $token = null;
                while ($tokenExists) {
                    $token = Str::random(64);
                    $existingToken = DB::table('tokens')->where('token', $token)->first();
                    if (!$existingToken) {
                        $tokenExists = false;
                    }
                }

                DB::table('tokens')->insert([
                    'user_id' => $employer->id,
                    'alamat_email' => $employer->alamat_email,
                    'category' => 'employer',
                    'token' => $token,
                    'type' => 'email_verification',
                    'expires_at' => now()->addMinutes(15),
                ]);
            }

            Mail::to($newEmail)->send(new EmailVerification($employer, $token));
        }
        $employer->update();
        return back()->with('success', 'Berhasil Mengubah Data Akun Perusahaan');
    }

    public function employerDelete($id)
    {
        $employer = Employer::findOrfail($id);
        if (!$employer) {
            return back()->with('warning', 'Akun Perusahaan Tidak Ditemukan');
        }
        $employer->delete();
        return back()->with('success', 'Berhasil Menghapus Akun Perusahaan Beserta Lowongan Kerja, Application');
    }

    public function lokerIndex()
    {
        $currentDate = Carbon::now();
        $endDate = Carbon::now()->endOfMonth();
        $startDate = $currentDate->copy()->subMonths(5)->startOfMonth();

        $loker = [
            'total' => Loker::count(),
            'all' => Loker::orderBy('created_at', 'DESC')->get(),
            'new' => Loker::whereBetween('created_at', [$currentDate->StartofMonth()->toDateString(), $currentDate->EndofMonth()->toDateString()])->count(),
            'open' => Loker::where('status', 'open')->count(),
            'closed' => Loker::where('status', 'closed')->count(),
        ];

        $period = $this->period($startDate, $endDate);
        $lokerNew = $this->getData($period, Loker::class);
        $lokerTotal = $this->countData($period, Loker::class);

        $jenisLokerChart = [
            'label' => Loker::select('jenis_pekerjaan')->distinct()->pluck('jenis_pekerjaan')->toArray(),
            'data' => [],
        ];

        foreach ($jenisLokerChart['label'] as $jenis) {
            $count = Loker::where('jenis_pekerjaan', $jenis)->count();
            $jenisLokerChart['data'][] = $count;
        }

        $tipeLokerChart = [
            'label' => Loker::select('tipe_pekerjaan')->distinct()->pluck('tipe_pekerjaan')->toArray(),
            'data' => [],
        ];

        foreach ($tipeLokerChart['label'] as $tipe) {
            $count = Loker::where('tipe_pekerjaan', $tipe)->count();
            $tipeLokerChart['data'][] = $count;
        }

        return view('admin.loker.index', compact('loker', 'lokerTotal', 'lokerNew', 'jenisLokerChart', 'tipeLokerChart'));
    }

    public function lokerDetail($id)
    {
        $loker = Loker::with('applicants.user.pengalaman', 'applicants.user.sertifikat', 'employer')->findOrfail($id);
        $totalApplicant = $loker->applicants->count();
        $statusApplicant = $loker->applicants->groupBy('status')->map->count();
        $applications = $loker->applicants()->orderBy('created_at', 'DESC')->with('user')->get();

        $status = [
            'labels' => $applications->pluck('status')->toArray(),
            'data' => $applications->groupBy('status')->map->count()->values()->toArray(),
        ];

        $category = [
            'itk' => $applications->where('user.nim', '!=', null)->count(),
            'not_itk' => $applications->where('user.nim', '=', null)->count(),
        ];
        return view('admin.loker.detail', compact('loker', 'status', 'category'));
    }

    public function lokerUpdate(Request $request, $id)
    {
        $loker = Loker::findOrfail($id);
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
        return back()->with('success', 'Berhasil Mengubah Detail Lowongan Kerja');
    }

    public function lokerDelete($id)
    {
        $loker = Loker::findOrfail($id);
        $loker->delete();
        return back()->with('success', 'Berhasil Menghapus Lowongan Kerja dan Lamaran Lowongan Kerja');
    }

    public function applicationUpdate(Request $request, $id)
    {
        $application = Application::findOrfail($id);
        if (!$application) {
            return back()->with('warning', 'Lamaran Tidak Ditemukan');
        }
        $validate = Validator::make($request->all(), [
            'status' => 'required|in:accepted,declined',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Status Lamaran');
        }

        $application->status = $request->input('status');
        $application->update();
        return back()->with('success', 'Berhasil Mengubah Status Lamaran');
    }

    public function applicationDelete(Request $request, $id)
    {
        $application = Application::findOrfail($id);
        if (!$application) {
            return back()->with('warning', 'Lamaran Tidak Ditemukan');
        }
        $application->delete();
        return back()->with('success', 'Berhasil Menghapus Lamaran');
    }

    public function userIndex()
    {
        $currentDate = Carbon::now('Asia/Makassar');
        $endDate = Carbon::now()->endOfMonth();
        $startDate = $currentDate->copy()->subMonths(5)->startOfMonth();
        $period = $this->period($startDate, $endDate);
        $user = [
            'all' => User::get(),
            'user_total' => User::count(),
            'user_itk' => User::whereNotNull('nim')->whereNotNull('email_verification')->count(),
            'user' => User::whereNull('nim')->whereNotNull('email_verification')->count(),
            'user_application' => User::with('applications')->has('applications')->count(),
            'user_nullApplication' => User::doesntHave('applications')->count(),
            'user_disability' => User::whereNotNull('disabilitas')->count(),
            'user_new' => User::whereBetween('created_at', [$currentDate->startOfMonth()->toDateString(), $currentDate->endOfMonth()->toDateString()])->whereNotNull('email_verification')->count(),
            'prodi' => Prodi::get(),
        ];
        $userData = $this->getData($period, User::class);
        $userNew = $this->countData($period, User::class);
        $userProdi = [
            'labels' => User::select('program_studi')->distinct()->pluck('program_studi')->toArray(),
            'data' => [],
        ];

        foreach ($userProdi['labels'] as $prodi) {
            $count = User::where('program_studi', $prodi)->count();
            $userProdi['data'][] = $count;
        }

        return view('admin.user.index', compact('user', 'userData', 'userNew', 'userProdi'));
    }

    public function userDetail($id)
    {
        $year = date('Y');
        $minYear = $year - 15;
        $maxYear = $year + 5;
        $years = range($minYear, $maxYear);
        $prodi = Prodi::get();
        $topik = Topic::get();
        $user = User::findOrfail($id);
        if (!$user) {
            return back()->with('warning', 'User Tidak Ditemukan');
        }
        $prodi = Prodi::get();
        $topik = Topic::get();
        $user->load('pengalaman', 'sertifikat', 'appointment', 'applications.loker.employer');

        return view('admin.user.detail', compact('user', 'prodi', 'topik', 'years', 'prodi', 'topik'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrfail($id);
        if (!$user) {
            return back()->with('warning', 'User Tidak Ditemukan');
        }
        $rule = [
            'nama_lengkap' => 'required',
            'nomor_telepon' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'kewarganegaraan' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'kode_pos' => 'required',
            'program_studi' => 'required',
            'nim' => 'required',
            'ipk' => 'required',
            'pendidikan_tertinggi' => 'required',
            'status_perkawinan' => 'required'
        ];

        if ($request->input('alamat_email') != $user->alamat_email) {
            $rule['alamat_email'] = 'required|unique:users,alamat_email';
        }

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Data Pengguna, Mohon Menginput Data Pada Form Dengan Benar');
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
                    'alamat_email' => $user->alamat_email,
                    'category' => 'user',
                    'token' => $token,
                    'type' => 'email_verification',
                    'expires_at' => now()->addMinutes(15),
                ]);
            }
            Mail::to($newEmail)->send(new EmailVerification($user, $token));
        }
        $user->update();
        return back()->with('success', 'Berhasil Mengubah Data Akun User');
    }

    public function userDelete($id)
    {
        $user = User::findOrfail($id);
        if (!$user) {
            return back()->with('warning', 'User Tidak Ditemukan');
        }
        $user->delete();
        return back()->with('success', 'Berhasil Menghapus User');
    }

    public function detailSertifikat($user, $id)
    {
        $user = User::findOrfail($user);
        $sertifikat = $user->sertifikat()->find($id);
        if (!$sertifikat) {
            return response()->json(['error' => 'Sertifikat Tidak Ditemukan'], 404);
        }
        return response()->json($sertifikat);
    }

    public function updateSertifikat(Request $request, $user, $id)
    {
        $user = User::findOrfail($user);
        $sertifikat = $user->sertifikat()->find($id);
        if (!$sertifikat) {
            return back()->with('warning', 'Sertifikat User Tidak Ditemukan');
        }
        $validation = Validator::make($request->all(), [
            'title_sertifikat' => 'required',
            'organisasi' => 'required',
            'bulan_terbit' => 'required',
            'tahun_terbit' => 'required',
            'bulan_berakhir' => 'required_with_all:tahun_berakhir',
            'tahun_berakhir' => 'required_with_all:bulan_berakhir',
            'id_sertifikat' => 'nullable',
            'url_sertifikat' => 'nullable',
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

    public function deleteSertifikat($user, $id)
    {
        $user = User::findOrfail($user);
        $sertifikat = $user->sertifikat()->find($id);
        if (!$sertifikat) {
            return back()->with('warning', 'Gagal Menghapus Sertifikat');
        }
        $sertifikat->delete();
        return back()->with('success', 'Berhasil Menghapus Sertifikat');
    }

    public function detailPengalaman($user, $id)
    {
        $user = User::findOrfail($user);
        $pengalaman = $user->pengalaman()->find($id);
        if (!$pengalaman) {
            return response()->json(['error' => 'Pengalaman Kerja Tidak Ditemukan'], 404);
        }
        return response()->json($pengalaman);
    }

    public function updatePengalaman(Request $request, $user, $id)
    {
        $user = User::findOrfail($user);
        $pengalaman = $user->pengalaman()->find($id);
        if (!$pengalaman) {
            return response()->json(['error' => 'Pengalaman Kerja Tidak Ditemukan'], 404);
        }

        $rules = [
            'title' => 'required',
            'jenis_pekerjaan' => 'required',
            'organisasi' => 'required',
            'lokasi_pekerjaan' => 'required',
            'bulan_mulai' => 'required',
            'tahun_mulai' => 'required',
            'deskripsi_pengalaman' => 'nullable',
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

    public function deletePengalaman($user, $id)
    {
        $user = User::findOrfail($user);
        $pengalaman = $user->sertifikat()->find($id);
        if (!$pengalaman) {
            return back()->with('warning', 'Gagal Menghapus Pengalaman');
        }
        $pengalaman->delete();
        return back()->with('success', 'Berhasil menghapus Sertifikat');
    }

    public function prodiNew(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'program_studi' => 'required',
            'jurusan' => 'required',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Menambahkan Program Studi');
        }

        $prodi = new Prodi;
        $prodi->program_studi = $request->input('program_studi');
        $prodi->jurusan = $request->input('jurusan');
        $prodi->save();

        return back()->with('success', 'Berhasil Menambahkan Program Studi');
    }

    public function prodiDetail($id)
    {
        $prodi = Prodi::findOrfail($id);
        if (!$prodi) {
            return back()->with('warning', 'Program Studi Tidak Ditemukan');
        }
        return $prodi;
    }

    public function prodiUpdate(Request $request, $id)
    {
        $prodi = Prodi::findOrfail($id);
        if (!$prodi) {
            return back()->with('warning', 'Program Studi Tidak Ditemukan');
        }

        $validate = Validator::make($request->all(), [
            'program_studi' => 'required',
            'jurusan' => 'required',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Data Program Studi');
        }

        User::where('program_studi', $prodi->program_studi)->update([
            'program_studi' => $request->input('program_studi'),
        ]);

        $prodi->update([
            'program_studi' => $request->input('program_studi'),
            'jurusan' => $request->input('jurusan'),
        ]);

        return back()->with('success', 'Berhasil Mengubah Data Program Studi');
    }

    public function prodiDelete($id)
    {
        $prodi = Prodi::findOrfail($id);
        if (!$prodi) {
            return back()->with('warning', 'Program Studi Tidak Ditemukan');
        }
        User::where('program_studi', $prodi->program_studi)->update([
            'program_studi' => '-',
        ]);
        $prodi->delete();
        return back()->with('success', 'Program Studi Berhasil Di Hapus');
    }

    public function appointmentIndex()
    {
        $currentDate = Carbon::now();
        $endDate = Carbon::now()->endOfMonth();
        $startDate = $currentDate->copy()->subMonths(5)->startOfMonth();
        $period = $this->period($startDate, $endDate);
        $appointment = [
            'all' => Appointment::with('user')->orderBy('created_at', 'DESC')->get(),
            'total' => Appointment::count(),
            'done' => Appointment::where('status', 'done')->count(),
            'approved' => Appointment::where('status', 'approved')->count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'week' => Appointment::whereBetween('created_at', [$currentDate->startOfWeek(), $currentDate->endOfWeek()])->where('status', 'approved')->count(),
        ];
        $appointmentData  = $this->getData($period, Appointment::class);
        $appointmentNew = $this->countData($period, Appointment::class);
        $appointmentTopicsChart = [
            'label' => Appointment::select('topik')->distinct()->pluck('topik')->toArray(),
            'data' => [],
        ];

        foreach ($appointmentTopicsChart['label'] as $topic) {
            $count = Appointment::where('topik', $topic)->count();
            $appointmentTopicsChart['data'][] = $count;
        }
        $topics = Topic::withCount('appointments')->get();

        return view('admin.appointment.index', compact('appointment', 'appointmentData', 'appointmentTopicsChart', 'topics'));
    }

    public function appointmentDetail($id)
    {
        $appointment = Appointment::findOrfail($id);
        if (!$appointment) {
            return response()->json(['message' => 'Appointment Tidak Ditemukan'], 404);
        }
        return response()->json($appointment);
    }

    public function appointmentEdit(Request $request, $id)
    {
        $appointment = Appointment::findOrfail($id);
        if (!$appointment) {
            return back()->with('warning', 'Appointment Tidak Ditemukan');
        }
        $validate = Validator::make($request->all(), [
            'topik' => 'required',
            'jenis_konseling' => 'required',
            'tempat_konseling' => 'required',
            'tanggal_konseling' => 'required',
            'jam_konseling' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Data Appointment');
        }
        $date = $request->input('tanggal_konseling');
        $time = $request->input('jam_konseling');
        $merge = new DateTime($date . ' ' . $time);
        if (Appointment::where('date_time', $merge)->exists()) {
            return back()->with('warning', 'Jadwal Konseling Telah Terisi, Mohon Mengganti Hari Atau Tanggal Jam Konseling');
        }
        $appointment->update([
            'topik' => $request->input('topik'),
            'jenis_konseling' => $request->input('jenis_konseling'),
            'tempat_konseling' => $request->input('tempat_konseling'),
            'date_time' => $merge->format('Y-m-d H:i:s'),
        ]);
        $userEmail = $appointment->user->alamat_email;
        Mail::to($userEmail)->send(new AppointmentNotification($appointment));
        return back()->with('success', 'Detail Appointment Berhasil Diubah');
    }

    public function appointmentDelete($id)
    {
        $appointment = Appointment::findOrfail($id);
        if (!$appointment) {
            return back()->with('warning', 'Appointment Tidak Ditemukan');
        }
        $appointment->delete();
        return back()->with('success', 'Berhasil Menghapus Appointment');
    }

    public function topicNew(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'topik' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Menambahkan Topik Konseling, Mohon Mengisi Ulang Form Dengan Benar');
        }

        $topic = new Topic;
        $topic->topik = $request->input('topik');
        $topic->save();

        return back()->with('success', 'Berhasil Menambahkan Topik Konseling Karir');
    }

    public function topicUpdate(Request $request, $id)
    {
        $topic = Topic::findOrfail($id);
        if (!$topic) {
            return back()->with('warning', 'Gagal Menemukan Topik Konseling');
        }

        $validate = Validator::make($request->all(), [
            'edit-topik' => 'required',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Topik, Mohon Mengisi Form Dengan Benar');
        }

        Appointment::where('topik', $topic->topik)->update(['topik' => $request->input('edit-topik')]);
        $topic->topik = $request->input('edit-topik');
        $topic->update();

        return back()->with('success', 'Berhasil Mengubah Topik Konseling');
    }

    public function topicDelete($id)
    {
        $topic = Topic::findOrfail($id);
        if (!$topic) {
            return back()->with('warning', 'Gagal Menemukan Topik Konseling');
        }
        Appointment::where('topik', $topic->topik)->delete();
        $topic->delete();
        return back()
            ->with('success', 'Berhasil Menghapus Topik Konseling Dan Appointment Konseling Yang Berhubungan Dengan Topik Ini');
    }

    public function appointmentNew(Request $request, $id)
    {
        $user = User::findOrfail($id);
        if (!$user) {
            return back()->with('warning', 'User Tidak Ditemukan');
        }
        $validate = Validator::make($request->all(), [
            'topik' => 'required',
            'jenis_konseling' => 'required',
            'tempat_konseling' => 'required',
            'tanggal_konseling' => 'required',
            'jam_konseling' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->with('warning', 'Mohon Mengisi Ulang Form Untuk Membuat Appointment Dengan Benar');
        }
        $date = $request->input('tanggal_konseling');
        $time = $request->input('jam_konseling');
        $merge = new DateTime($date . ' ' . $time);
        $appointment = new Appointment;
        $appointment->topik = $request->input('topik');
        $appointment->jenis_konseling = $request->input('jenis_konseling');
        $appointment->tempat_konseling = $request->input('tempat_konseling');
        $appointment->date_time = $merge->format('Y-m-d H:i:s');
        $appointment->user_id = $user->id;
        $appointment->status = 'accepted';
        $appointment->save();

        Mail::to($user->alamat_email)->send(new AppointmentNotification($appointment));
        return back()->with('success', 'Berhasil Membuat Appointment Baru');
    }

    public function appointmentResponse(Request $request, $id)
    {
        $appointment = Appointment::with('user')->findOrfail($id);
        if (!$appointment) {
            return back()->with('warning', 'Appointment Tidak Ditemukan');
        }
        $appointment->status = $request->input('status');
        $appointment->feedback = $request->input('feedback');
        $appointment->update();
        Mail::to($appointment->user->alamat_email)->send(new AppointmentNotification($appointment));
        return back()->with('success', 'Berhasil Mengubah Status Appointment, Email Notifikasi Telah Dikirim Kepada Peserta');
    }

    public function finishAppointment(Request $request, $id)
    {
        $appointment = Appointment::findOrfail($id);
        if (!$appointment && !$appointment->status == 'Accepted') {
            return back()->with('warning', 'Appointment Tidak Ditemukan Atau Appointment Masih Belum Disetujui');
        }
        $appointment->status = $request->input('status');
        $appointment->update();
        return back()->with('success', 'Berhasil Mengubah Status Appointment Menjadi Selesai');
    }

    public function contentIndex()
    {
        $content = Content::orderBy('created_at', 'DESC')->get();
        return view('admin.content.index', compact('content'));
    }

    public function newContent(Request $request)
    {
        $rules = [
            'category' => 'required',
            'title_content' => 'required',
        ];

        if ($request->input('category') === 'Carousel') {
            $rules['img_content'] = 'required|mimes:png';
        } elseif ($request->input('category') === 'Berita') {
            $rules['img_content'] = 'nullable|mimes:png';
            $rules['body_content'] = 'required';
        }
        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return back()->with('warning', 'Mohon Mengisi Ulang Kembali Form');
        }

        $content = new Content;
        $content->category = $request->input('category');
        $content->status = true;
        $content->title = $request->input('title_content');
        $content->body = $request->input('body_content');

        $content->save();

        if ($request->hasFile('img_content')) {
            $image = $request->file('img_content');
            $imageName = $content->id . '.png';
            $image->storeAs('content', $imageName);
            $content->image = $imageName;
            $content->save();
        }
        return redirect()->route('admin.contents')->with('success', 'Berhasil Menambahkan Konten Baru');
    }

    public function detailContent($id)
    {
        $contentDetail = Content::findOrfail($id);
        return $contentDetail;
    }

    public function updateContent(Request $request, $id)
    {
        $content = Content::findOrfail($id);
        $image = $content->image;
        if (!$content) {
            return back()->with('warning', 'Konten Tidak Ditemukan');
        }

        $rule = [
            'category' => 'required',
            'editTitle' => 'required'
        ];

        if ($request->input('category') === 'Berita') {
            $rule['edit_image'] = 'nullable|mimes:png';
            $rule['editBody'] = 'required';
        } elseif ($request->input('category') === 'Carousel') {
            $rule['edit_image'] = 'required|mimes:png';
            $rule['editBody'] = 'nullable';
        }

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {
            return back()->with('warning', 'Mohon Mengisi Ulang Form');
        }

        $newImage = $content->id . '.png';
        $content->title = $request->input('editTitle');
        $content->body = $request->input('editBody');
        $content->status = $request->input('editStatus') ? 1 : 0;
        if ($request->hasFile('editImage')) {
            Storage::delete('/public/content/' . $image);
            $request->file('edit_image')->storeAs('content', $newImage);
        }
        if ($request->filled('deleteImage')) {
            Storage::delete('/public/content/' . $image);
            $content->image = '';
        }
        $content->update();
        return back()->with('success', 'Berhasil Mengubah Konten');
    }

    public function deleteContent($id)
    {
        $content = Content::findOrfail($id);
        if ($content) {
            $image = $content->image;
            Storage::delete('/public/content/' . $image);
            $content->delete();
            return redirect()->route('admin.contents')->with('success', 'Berhasil Menghapus Konten');
        } else {
            return back()->with('warning', 'Konten Tidak Ditemukan');
        }
    }

    public function carouselNew(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'carouselTitle' => 'required',
            'carouselCaption' => 'nullable',
            'carouselImage' => 'required|mimes:png',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Mohon mengisi ulang form dengan benar');
        }

        $carousel = new Content;
        $carousel->title = $request->input('carouselTitle');
        $carousel->body = $request->input('carouselCaption');
        $carousel->status = true;
        $carousel->category = 'Carousel';
        $carousel->save();

        if ($request->hasFile('carouselImage')) {
            $carouselImage = $request->file('carouselImage');
            $carouselName = $carousel->id . '.png';
            $carouselImage->storeAs('content', $carouselName);
            $carousel->image = $carouselName;
            $carousel->save();
        }
        return redirect('/contents/carousel')->with('success', 'Berhasil Menambah Carousel');
    }

    public function carouselUpdate(Request $request, $id)
    {
        $carousel = Content::findOrfail($id);

        $validate = Validator::make($request->all(), [
            'carouselTitle' => 'required',
            'carouselCaption' => 'nullable',
            'carouselStatus' => 'nullable',
            'carouselImage' => 'required|mimes:png',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Mohon Mengisi Ulang Form');
        }

        $activeCarousel = Content::where('status', '=', 'Active')->exists();
        if ($activeCarousel) {
            return back()->with('warning', 'Carousel Diperlukan Pada Homepage');
        }

        $newCarousel = $carousel->image;
        $carousel->title = $request->input('carouselTitle');
        $carousel->body = $request->input('carouselCaption');
        $carousel->Status = $request->input('carouselStatus');

        if ($request->hasFile('carouselImage')) {
            Storage::delete('/public/content/' . $carousel->image);
            $request->file('carouselImage')->storeAs('content', $newCarousel);
        }

        return back()->with('success', 'Berhasil Mengubah Carousel');
    }

    public function carouselDelete($id)
    {
        $carousel = Content::findOrfail($id);
        $activeCarousel = Content::where('status', '=', 'Active')->exists();
        if ($activeCarousel) {
            return back()->with('warning', 'Carousel Diperlukan Pada Homepage');
        }
        if ($carousel) {
            Storage::delete('/public/content/' . $carousel->image);
            $carousel->delete();
            return redirect('/contents/carousel')->with('success', 'Berhasil Menghapus Carousel');
        }
        return back()->with('warning', 'Carousel Tidak Ditemukan');
    }
}
