<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Employer;
use Illuminate\Support\Facades\Redirect;
use App\Models\Approval;
use App\Models\Loker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class AdminController extends Controller
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
        $approvalMonthly = Approval::whereMonth('created_at', date('m'))->where('status', '=', 'pending')->count();
        $approved = Approval::whereMonth('created_at', date('m'))->where('status', '=', 'approved')->count();
        $total = Approval::count();

        $employer = Employer::count();
        $employerMonthly = Employer::whereMonth('created_at', date('m'))->count();

        $loker = Loker::count();
        $lokerMonthly = Loker::whereMonth('created_at', date('m'))->count();

        $pending = Appointment::where('status', '=', 'Pending')->count();
        $finish = Appointment::where('status', '=', 'Finished')->count();

        return view('admin.index', compact(
            'approvalMonthly',
            'approved',
            'total',
            'employer',
            'employerMonthly',
            'loker',
            'lokerMonthly',
            'pending',
            'finish',
        ));
    }

    public function approvalPage()
    {
        $pending = Approval::where('status', '=', 'Pending')->get();
        $approved = Approval::where('status', '=', 'Approved')->get();
        return view('admin.approval.index', compact('pending', 'approved'));
    }

    public function approvalEmployer(Request $request, $id)
    {
        $approval = Approval::findOrfail($id);
        if ($approval) {
            $employer = new Employer;
            $employer->username = data_get($approval, 'username');
            $employer->password = Hash::make(data_get($approval, 'password'));
            $employer->nama_perusahaan = data_get($approval, 'nama_perusahaan');
            $employer->alamat = data_get($approval, 'alamat');
            $employer->provinsi = data_get($approval, 'provinsi');
            $employer->kota = data_get($approval, 'kota');
            $employer->kode_pos = data_get($approval, 'kode_pos');
            $employer->website = data_get($approval, 'website');
            $employer->nama_lengkap = data_get($approval, 'nama_lengkap');
            $employer->jabatan = data_get($approval, 'jabatan');
            $employer->nomor_telepon = data_get($approval, 'nomor_telepon');
            $employer->alamat_email = data_get($approval, 'alamat_email');
            $employer->save();

            $approval->status = 'Approved';
            $approval->update();
            return back()->with('success', 'Berhasil Membuat Akun Employer');
        } else {
            return back()->with('error', 'Terjadi Kesalahan Mohon Mengajukan ulang');
        }
    }

    public function employerIndex()
    {
        $employer = Employer::get();
        return view('admin.employer.index', compact('employer'));
    }

    public function lokerIndex()
    {
        $loker = Loker::get();
        return view('admin.loker.index', compact('loker'));
    }

    public function appointmentIndex()
    {
        $appointments = Appointment::with('user')->orderBy('created_at', 'asc')->paginate(20);
        return view('admin.appointment.index', compact('appointments'));
    }

    public function events()
    {
        $events = [];
        $appointment = Appointment::with('user')->get();
        // $today = Appointment::whereDate('date_time', Carbon::today())->where('status', '=', 'Approved')->get();
        foreach ($appointment as $item) {
            $events[] = [
                'title' => $item->user->nama_lengkap,
                'start' => $item->date_time,
                'color' => $item->color,
            ];
        }
        return response()->json($events);
    }

    public function renderAppointments(Request $request)
    {
        $appointments = Appointment::with('user')->orderBy('created_at', 'asc')->paginate(20);
        return view('admin.appointment.render', compact('appointments'))->render();
    }

    public function filterAppointments(Request $request)
    {
        $filter = $request->input('filter', []);
        return $filter;
    }

    public function approveAppointment($id)
    {
        $appointment = Appointment::findOrfail($id);
        if ($appointment) {
            $appointment->status = 'Approved';
            $appointment->color = '#0d6efd';
            $appointment->update();
            return back()->with('success', 'Appointment Telah Di setujui');
        } else {
            return back()->with('warning', 'Appointment Tidak Ditemukan');
        }
    }

    public function finishAppointment($id)
    {
        $appointment = Appointment::findOrfail($id);
        if ($appointment) {
            $appointment->status = 'Finished';
            $appointment->color = '#198754';
            $appointment->update();
            return back()->with('success', 'Appointment Telah Dilakukan');
        } else {
            return back()->with('warning', 'Appointment Tidak Ditemukan');
        }
    }
}
