<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Appointment;
use App\Models\Application;
use App\Models\Approval;
use App\Models\Loker;
use App\Models\User;
use App\Models\Employer;
use App\Models\Admin;
use App\Models\Content;
use App\Models\Topic;
use App\Models\Prodi;
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
        $startDate = $currentDate->copy()->subMonths(6)->startOfMonth();
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
        $startDate = $currentDate->copy()->subMonths(6)->startOfMonth();

        $period = $this->period($startDate, $endDate);
        $approvalDataChart = $this->getData($period, Approval::class);
        $newApprovalChart = $this->countData($period, Approval::class);
        $all = Approval::orderBy('created_at', 'DESC')->get();
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

        return back()->with('success', 'Approval Akun Perusahaan Berhasil di Hapus');
    }

    public function approvalUpdate(Request $request, $id)
    {
        $approval = Approval::findOrfail($id);
        if (!$approval) {
            return back()->with('warning', 'Nomor Approval Tidak Ditemukan');
        }

        $rule = [
            'approval_status' => 'required|in:accepted,declined',
        ];

        if ($request->input('approval_status') == 'declined') {
            $rule['approval_feedback'] = 'required|string|max:1024|min:8';
        }

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput()->with('modal', 'approvalModal');
        }

        $approval->update(['status' => $request->input('approval_status')]);
        if ($approval->status == 'accepted') {
            $employer = new Employer;
            $employer->username = $approval->username;
            $employer->password = $approval->password;
            $employer->nama_perusahaan = $approval->nama_perusahaan;
            $employer->alamat = $approval->alamat;
            $employer->provinsi = $approval->provinsi;
            $employer->kota = $approval->kota;
            $employer->kode_pos = $approval->kode_pos;
            $employer->website = $approval->website;
            $employer->bidang_perusahaan = $approval->bidang_perusahaan;
            $employer->tahun_berdiri = $approval->tahun_berdiri;
            $employer->kantor_pusat = $approval->kantor_pusat;
            $employer->nama_lengkap = $approval->nama_lengkap;
            $employer->jabatan = $approval->jabatan;
            $employer->nomor_telepon = $approval->nomor_telepon;
            $employer->alamat_email = $approval->alamat_email;
            $employer->status = 'active';
            $employer->email_verification = null;
            $employer->save();
        }

        $template = ($approval->status === 'accepted') ? 'admin.approval.mail.approval-accepted' : 'admin.approval.mail.approval-declined';
        $subject = 'Notifikasi: Persetujuan Pembuatan Akun Perusahaan';
        $feedback = $request->input('approval_feedback');

        Mail::to($approval->alamat_email)->send(new ApprovalNotification($subject, $approval, $template, $feedback));
        return back()->with('success', 'Berhasil Mengubah Status Approval');
    }

    public function employerIndex()
    {
        $currentDate = Carbon::now();
        $endDate = Carbon::now()->endOfMonth();
        $startDate = $currentDate->copy()->subMonths(6)->startOfMonth();

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
        $loker = $employer->loker()->orderBy('created_at', 'DESC')->withTrashed()->get();
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
            'nama_perusahaan' => 'required|string|min:4|max:128',
            'alamat_perusahaan' => 'required|string|min:8|max:256',
            'kota' => 'required|string|min:4|max:64',
            'provinsi' => 'required|string|min:4|max:64',
            'kantor_pusat' => 'required|string|min:4|max:256',
            'website' => 'required|url|min:8|max:128',
            'bidang_perusahaan' => 'required|string|min:8|max:128',
            'tahun_berdiri' => 'required|digits:4|numeric|min:1900|max:' . date('Y'),
            'kode_pos' => 'required|numeric|digits_between:4,6',
            'nama_employer' => 'required|string|min:4|max:128',
            'nomor_telepon' => 'required|digits_between:10,14',
            'jabatan' => 'required|string|min:8|max:128',
            'status' => 'required|in:active,suspended',
        ];

        if ($request->input('alamat_email') != $employer->alamat_email) {
            $rule['alamat_email'] = 'required|unique:employers,alamat_email';
        }

        if ($request->input('status') == 'suspended') {
            $rule['suspend_note'] = 'required|string|max:1064|min:8';
        }

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'editEmployer');
        }

        if ($request->input('alamat_email') != $employer->alamat_email) {
            $newEmail = $request->input('alamat_email');
            $employer->email_verification = null;
            $employer->alamat_email = $newEmail;

            $tokenRecord = DB::table('tokens')->where('user_id', $employer->id)
                ->where('category', 'employer')
                ->where('type', 'email_verification')
                ->first();

            if (!$tokenRecord) {
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
            } else {
                $token = $tokenRecord->token;
            }

            Mail::to($newEmail)->send(new EmailVerification($employer, $token));
        }

        if ($request->input('status') == 'suspended') {
            $employer->status = $request->input('status');
            $employer->suspend_note = $request->input('suspend_note');

            $lokers = $employer->loker;

            if ($lokers->isNotEmpty()) {
                foreach ($lokers as $loker) {
                    $loker->update(['status' => 'closed']);

                    $loker->applicants()->where('status', 'pending')->update(['status' => 'declined']);
                }
            }
        } elseif ($request->input('status') == 'active') {
            $employer->suspend_note = "";
        }

        $employer->nama_perusahaan = $request->input('nama_perusahaan');
        $employer->alamat = $request->input('alamat_perusahaan');
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
        $employer->status = $request->input('status');
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
        return redirect()->route('admin.employer')->with('success', 'Berhasil Menghapus Data Perusahaan');
    }

    public function lokerIndex()
    {
        $currentDate = Carbon::now();
        $endDate = Carbon::now()->endOfMonth();
        $startDate = $currentDate->copy()->subMonths(6)->startOfMonth();

        $loker = [
            'total' => Loker::count(),
            'all' => Loker::orderBy('created_at', 'DESC')->withTrashed()->get(),
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
        $loker = Loker::withTrashed()->with('applicants.user.pengalaman', 'applicants.user.sertifikat', 'employer')->findOrfail($id);
        $totalApplicant = $loker->applicants->count();
        $statusApplicant = $loker->applicants->groupBy('status')->map->count();
        $applications = $loker->applicants()->orderBy('created_at', 'DESC')->withTrashed()->with('user')->get();

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

        $rule = [
            'nama_pekerjaan' => 'required|string|min:8|max:128',
            'jenis_pekerjaan' => 'required|string|min:2|max:64',
            'tipe_pekerjaan' => 'required|string|min:2|max:64',
            'status_pekerjaan' => 'required|in:Open,Closed,Suspended',
            'deskripsi_pekerjaan' => 'required|string|min:64|max:2048',
            'lokasi_pekerjaan' => 'required|string|min:4|max:128',
            'poster' => 'nullable|file|mimes:png,jpeg|max:1024',
            'deadline' => 'required|date|after_or_equal:today',
        ];

        $validate = Validator::make($request->all(), $rule);

        if ($request->input('status_pekerjaan' == 'Suspended')) {
            $rule['feedback_status_pekerjaan'] = 'required|string|max:1024';
        }
        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'editLoker');
        }
        $loker->nama_pekerjaan = $request->input('nama_pekerjaan');
        $loker->jenis_pekerjaan = $request->input('jenis_pekerjaan');
        $loker->tipe_pekerjaan = $request->input('tipe_pekerjaan');
        $loker->deskripsi_pekerjaan = $request->input('deskripsi_pekerjaan');
        $loker->lokasi_pekerjaan = $request->input('lokasi_pekerjaan');
        $loker->status = $request->input('status_pekerjaan');
        if ($request->input('status_pekerjaan' == 'Suspended')) {
            $loker->suspend_note = $request->input('feedback_status_pekerjaan');
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
        $loker = Loker::findOrFail($id);
        $employerId = $loker->employer->id;
        $loker->delete();
        return redirect()->route('admin.employer.detail', ['id' => $employerId])->with('success', 'Berhasil Menghapus Lowongan Pekerjaan');
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

    public function applicationDelete($id)
    {
        $application = Application::findOrfail($id);
        if (!$application) {
            return back()->with('warning', 'Lamaran Tidak Ditemukan');
        }
        $application->forceDelete();
        return back()->with('success', 'Berhasil Menghapus Lamaran');
    }

    public function userIndex()
    {
        $currentDate = Carbon::now('Asia/Makassar');
        $endDate = Carbon::now()->endOfMonth();
        $startDate = $currentDate->copy()->subMonths(6)->startOfMonth();
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
        $topik = Topic::where('status', 'enable')->get();
        $user = User::findOrfail($id);
        if (!$user) {
            return back()->with('warning', 'User Tidak Ditemukan');
        }
        $appointment = Appointment::with('user')->orderBy('created_at', 'DESC')->get();
        $user->load('pengalaman', 'sertifikat', 'appointment', 'applications.loker.employer');

        return view('admin.user.detail', compact('user', 'prodi', 'topik', 'years', 'prodi', 'topik', 'appointment'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrfail($id);
        if (!$user) {
            return back()->with('warning', 'User Tidak Ditemukan');
        }
        $rule = [
            'nama_lengkap' => 'required|string|min:4|max:128',
            'nomor_telepon' => 'required|numeric|digits_between:10,14',
            'tempat_lahir' => 'required|string|min:4|max:64',
            'tanggal_lahir' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'kewarganegaraan' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'agama' => 'required|string',
            'alamat' => 'required|string|min:10|max:256',
            'kota' => 'required|string|min:4|max:64',
            'kode_pos' => 'required|digits_between:4,6',
            'program_studi' => 'required|string',
            'nim' => 'required|numeric',
            'ipk' => 'max:4|min:1|required',
            'pendidikan_tertinggi' => 'required|string',
            'status_perkawinan' => 'required|string',
            'user_status' => 'required|in:active,suspended'
        ];

        if ($request->input('alamat_email') != $user->alamat_email) {
            $rule['alamat_email'] = 'required|email|unique:users,alamat_email';
        }

        if ($request->input('user_status') == 'suspended') {
            $rule['user_suspend_note'] = 'required|string|max:1064|min:8';

            $user->suspend_note = $request->input('user_suspend_note');
        } elseif ($request->input('user_status') == 'active') {
            $user->suspend_note = "";
        }

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'editUser');
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
        $user->status = $request->input('user_status');
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
        return redirect()->route('admin.user')->with('success', 'Berhasil Menghapus Data User');
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
            'title_sertifikat' => 'required|string|min:4|max:64',
            'organisasi_sertifikat' => 'required|string|min:4|max:64',
            'bulan_terbit_sertifikat' => 'required|digits_between:1,2|min:1|max:12',
            'tahun_terbit_sertifikat' => 'required|digits:4',
            'bulan_berakhir_sertifikat' => 'required_with_all:tahun_berakhir|digits_between:1,2|min:1|max:12',
            'tahun_berakhir_sertifikat' => 'required_with_all:bulan_berakhir|digits:4|gte:tahun_terbit_sertifikat',
            'id_sertifikat' => 'nullable|string|min:4|max:128',
            'url_sertifikat' => 'nullable|url|min:4|max:128',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->with('modal', 'editSertifikat');
        }
        $sertifikat->title = $request->input('title_sertifikat');
        $sertifikat->organisasi = $request->input('organisasi_sertifikat');
        $released_date = '01-' . str_pad($request->input('bulan_terbit_sertifikat'), 2, '0', STR_PAD_LEFT) . '-' . $request->input('tahun_terbit_sertifikat');
        $format_released_date = DateTime::createFromFormat('d-m-Y', $released_date);
        $tanggal_terbit = $format_released_date->format('F Y');
        $sertifikat->tanggal_terbit = $tanggal_terbit;
        if (!empty($request->input('bulan_berakhir_sertifikat')) && !empty($request->input('tahun_berakhir_sertifikat'))) {
            $end_date = '01-' . str_pad($request->input('bulan_berakhir_sertifikat'), 2, '0', STR_PAD_LEFT) . '-' . $request->input('tahun_berakhir_sertifikat');
            $format_end_date = DateTime::createFromFormat('d-m-Y', $end_date);
            $tanggal_berakhir = $format_end_date->format('F Y');
            $sertifikat->tanggal_berakhir = $tanggal_berakhir;
        }
        $sertifikat->id_sertifikat = $request->input('id_sertifikat');
        $sertifikat->url_sertifikat = $request->input('url_sertifikat');
        $sertifikat->user_id = $user->id;
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
            'title_pengalaman' => 'required|string|min:4|max:128',
            'organisasi_pengalaman' => 'required|string|min:5|max:128',
            'lokasi_pekerjaan_pengalaman' => 'required|string|min:5|max:256',
            'bulan_mulai_pengalaman' => 'required|digits_between:1,2|min:1|max:12',
            'tahun_mulai_pengalaman' => 'required|digits:4',
            'deskripsi_pengalaman' => 'nullable|min:10|max:512',
        ];
        if ($request->has('present_box')) {
            $rules['bulan_selesai_pengalaman'] = 'nullable|digits_between:1,2|min:1|max:12';
            $rules['tahun_selesai_pengalaman'] = 'nullable|digits:4';
        } else {
            $rules['bulan_selesai_pengalaman'] = 'required|digits_between:1,2|min:1|max:12';
            $rules['tahun_selesai_pengalaman'] = 'required|digits:4|gte:' . $request->input('tahun_mulai_pengalaman');
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
        $pengalaman->title = $request->input('title_pengalaman');
        $pengalaman->organisasi = $request->input('organisasi_pengalaman');
        $pengalaman->lokasi_pekerjaan = $request->input('lokasi_pekerjaan_pengalaman');
        $pengalaman->tanggal_mulai = $formatDate($request->input('bulan_mulai_pengalaman'), $request->input('tahun_mulai_pengalaman'));
        if ($request->has('present_box')) {
            $pengalaman->tanggal_selesai = 'present';
        } else {
            $pengalaman->tanggal_selesai = $formatDate($request->input('bulan_selesai_pengalaman'), $request->input('tahun_selesai_pengalaman'));
        }
        $pengalaman->deskripsi = $request->input('deskripsi_pengalaman');
        $pengalaman->user_id = $user->id;
        $pengalaman->update();

        return back()->with('success', 'Berhasil Mengubah Data Pengalaman Kerja');
    }

    public function deletePengalaman($user, $id)
    {
        $user = User::findOrfail($user);
        $pengalaman = $user->pengalaman()->find($id);
        if (!$pengalaman) {
            return back()->with('warning', 'Gagal Menghapus Pengalaman');
        }
        $pengalaman->delete();
        return back()->with('success', 'Berhasil menghapus Pengalaman Kerja User');
    }

    public function detailPendidikan($user, $id)
    {
        $user = User::findOrfail($user);
        $pendidikan = $user->pendidikan()->find($id);
        if (!$pendidikan) {
            return response()->json(['error' => 'Data Pendidikan Tidak Ditemukan'], 404);
        }
        return response()->json($pendidikan);
    }

    public function updatePendidikan(Request $request, $user, $id)
    {
        $user = User::findOrfail($user);
        $pendidikan = $user->pendidikan()->find($id);
        if (!$pendidikan) {
            return response()->json(['error' => 'Data Pendidikan Tidak Ditemukan']);
        }
        $rules = [
            'nama_sekolah' => 'required|string|max:128',
            'tingkat_pendidikan' => 'required|string|min:2|max:32',
            'bidang_studi' => 'required|string|min:3|max:64',
            'alamat_sekolah' => 'required|string|max:256',
            'tahun_lulus' => 'required|integer|digits:4|min:1990|max:' . date('Y'),
            'keterangan' => 'nullable|string|max:512'
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'editPendidikan');
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

    public function deletePendidikan($user, $id)
    {
        $user = User::findOrfail($user);
        $pendidikan = $user->pendidikan()->find($id);
        if (!$pendidikan) {
            return response()->json(['error' => 'Data Pendidikan Tidak Ditemukan']);
        }
        $pendidikan->delete();
        return back()->with('success', 'Berhasil Menghapus Data Pendidikan');
    }

    public function prodiNew(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'program_studi_new' => 'required|string|min:4|max:64',
            'jurusan_new' => 'required|string|min:4|max:64',
            'fakultas_new' => 'nullable|string|min:3|max:64',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput()->with('modal', 'newProdi');
        }

        $prodi = new Prodi;
        $prodi->program_studi = $request->input('program_studi_new');
        $prodi->jurusan = $request->input('jurusan_new');
        $prodi->fakultas = $request->input('fakultas_new');
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
            'program_studi_edit' => 'required|string|min:3|max:64',
            'jurusan_edit' => 'required|string|min:3',
            'fakultas_edit' => 'nullable|string|min:3',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'editProdi');
        }

        User::where('program_studi', $prodi->program_studi)->update([
            'program_studi' => $request->input('program_studi_edit'),
        ]);

        $prodi->update([
            'program_studi' => $request->input('program_studi_edit'),
            'jurusan' => $request->input('jurusan_edit'),
            'fakultas' => $request->input('fakultas_edit'),
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
        $startDate = $currentDate->copy()->subMonths(6)->startOfMonth();
        $period = $this->period($startDate, $endDate);
        $appointment = [
            'all' => Appointment::with('user')->orderBy('created_at', 'DESC')->get(),
            'total' => Appointment::count(),
            'done' => Appointment::where('status', 'finished')->count(),
            'approved' => Appointment::where('status', 'accepted')->count(),
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
            return back()->with('warning', 'Data Appointment Tidak Ditemukan');
        }
        $topik = Topic::pluck('topik')->toArray();
        $topikString = implode(',', $topik);
        $rule = [
            'topik_konseling_edit' => 'required|string|in:' . $topikString,
            'jenis_konseling_edit' => 'required|string|in:individu,kelompok',
            'tempat_konseling_edit' => 'required|string|in:Online,Offline',
            'tanggal_konseling_edit' => 'required|date|after_or_equal:today',
            'jam_konseling_edit' => 'required',
        ];

        if ($request->input('jenis_konseling_edit' === 'kelompok')) {
            $rule['jumlah_peserta_konseling_edit'] = 'required';
        }

        if ($request->input('tempat_konseling_edit') === 'Online') {
            $rule['google_meet_edit'] = 'required';
        }
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'editAppointment');
        }
        $date = $request->input('tanggal_konseling_edit');
        $time = $request->input('jam_konseling_edit');
        $merge = new DateTime($date . ' ' . $time);
        $formatDateTime = $merge->format('Y-m-d H:i:s');
        if (Appointment::where('date_time', $formatDateTime)->exists() && $formatDateTime != $appointment->date_time) {
            return back()->with('filled', 'Jadwal Konseling Telah Terisi, Mohon Mengganti Hari atau Jam Konseling')->withInput()->with('modal', 'editAppointment');
        }
        $appointment->update([
            'topik' => $request->input('topik_konseling_edit'),
            'jenis_konseling' => $request->input('jenis_konseling_edit'),
            'jumlah_peserta' => $request->filled('jumlah_peserta_konseling_edit') ? $request->input('jumlah_peserta_konseling_edit') : null,
            'tempat_konseling' => $request->input('tempat_konseling_edit'),
            'date_time' => $merge->format('Y-m-d H:i:s'),
            'google_meet' => $request->filled('google_meet_edit') ? $request->input('google_meet_edit') : null,
        ]);
        $userEmail = $appointment->user->alamat_email;
        Mail::to($userEmail)->send(new AppointmentNotification($appointment));
        return back()->with('success', 'Detail Appointment Berhasil Diubah dan Berhasil Mengirim Email Notifikasi Kepada Peserta Konseling');
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
            'topik_konseling' => 'required|string|min:8|max:64',
            'status_topik_konseling' => 'required|in:enable,disable',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput()->with('modal', 'addTopic');
        }

        $topic = new Topic;
        $topic->topik = $request->input('topik_konseling');
        $topic->status = $request->input('status_topik_konseling');
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
            'edit_topik' => 'required|string|min:8|max:64',
            'edit_status_topik' => 'required|in:enable,disable'
        ]);

        if ($request->input('edit_status_topik') == 'disable') {
            Appointment::where('topik', $topic->topik)->where('status', 'on process')->update(['status' => 'declined']);
        }

        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'editTopic');
        }

        Appointment::where('topik', $topic->topik)->update(['topik' => $request->input('edit_topik')]);
        $topic->topik = $request->input('edit_topik');
        $topic->status = $request->input('edit_status_topik');
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

        $rule = [
            'topik_konseling' => 'required|string',
            'jenis_konseling' => 'required|string',
            'tempat_konseling' => 'required|string',
            'tanggal_konseling' => 'required|date',
            'jam_konseling' => 'required',
        ];

        if ($request->input('jenis_konseling') === 'kelompok') {
            $rule['jumlah_peserta_konseling'] = 'required|numeric|min:1|max:5';
        }

        if ($request->input('tempat_konseling') === "Online") {
            $rule['google_meet'] = 'required';
        }

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            dd($validate);
            return back()->withErrors($validate)->withInput()->with('modal', 'newAppointment');
        }
        $date = $request->input('tanggal_konseling');
        $time = $request->input('jam_konseling');
        $merge = new DateTime($date . ' ' . $time);
        $appointment = new Appointment;
        $appointment->topik = $request->input('topik_konseling');
        $appointment->jenis_konseling = $request->input('jenis_konseling');
        $appointment->jumlah_peserta = $request->filled('jumlah_peserta_konseling') ? $request->input('jumlah_peserta_konseling') : null;
        $appointment->tempat_konseling = $request->input('tempat_konseling');
        $appointment->date_time = $merge->format('Y-m-d H:i:s');
        $appointment->user_id = $user->id;
        $appointment->status = 'accepted';
        $appointment->google_meet = $request->filled('google_meet') ? $request->input('google_meet') : null;
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
            'category' => 'required|string',
            'title_content' => 'required|string|min:5|max:100',
        ];

        if ($request->input('category') === 'Carousel') {
            $rules['img_content'] = 'required|file|mimes:png,jpeg,jpg|max:2048';
        } elseif ($request->input('category') === 'Berita') {
            $rules['img_content'] = 'nullable|file|mimes:png,jpeg,jpg|max:2048';
            $rules['body_content'] = 'required|string|min:25';
        }
        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput()->with('modal', 'newContent');
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
            'category' => 'required|string',
            'editTitle' => 'required|string|min:5|max:155'
        ];

        if ($request->input('category') === 'Berita') {
            $rule['edit_image'] = 'nullable|file|mimes:png,jpeg|max:2048';
            $rule['editBody'] = 'required';
        } elseif ($request->input('category') === 'Carousel') {
            $rule['edit_image'] = 'required|file|mimes:png|max:2048';
            $rule['editBody'] = 'nullable|string|max:10';
        }

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {
            return back()->withErrors($validate)->with('modal', 'editContent');
        }

        $newImage = $content->id . '.png';
        $content->title = $request->input('editTitle');
        $content->body = $request->input('editBody');
        $content->status = $request->input('editStatus') ? 1 : 0;
        if ($request->hasFile('edit_image')) {
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

    public function resetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Password');
        }

        $admin = Admin::findOrfail(Auth('admin')->user()->id);
        $admin->password = Hash::make($request->input('new_password'));
        $admin->save();
        return back()->with('success', 'Berhasil Mengubah Password');
    }
}
