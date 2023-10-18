<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Approval;
use App\Models\Loker;
use App\Models\User;
use App\Models\Employer;
use App\Models\Content;
use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

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
        $approval = Approval::get();
        $total = Approval::count();
        $pending = Approval::where('status', 'pending')->count();
        $approved = Approval::where('status', 'approved')->count();
        $notApproved = Approval::where('status', 'not approved')->count();
        return view('admin.approval.index', compact('approval', 'total', 'approved', 'notApproved'));
    }

    public function approvalUpdate(Request $request, $id)
    {
        $approval = Approval::findOrfail($id);
        if (!$approval) {
            return back()->with('warning', 'Nomor Approval Tidak Ditemukan');
        }
        $validate = Validator::make($request->all(), [
            'status' => 'required|in:approved,not approved',
        ]);
        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Status Approval');
        }

        $approval->update(['status' => $request->input('status')]);
        return back()->with('success', 'Berhasil Mengubah Status Approval');
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

    public function contentIndex()
    {
        $content = Content::where('category', '=', 'Berita')->orderBy('created_at', 'DESC')->get();
        return view('admin.content.index', compact('content'));
    }

    public function formContent()
    {
        return view('admin.content.create');
    }

    public function newContent(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'image_content' => 'nullable|mimes:png',
            'title_content' => 'required',
            'body_content' => 'required',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Mohon Mengisi Ulang Kembali Form');
        }

        $content = new Content;
        $content->category = 'Berita';
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
        return redirect('/contents')->with('success', 'Berhasil Menambahkan Konten Baru');
    }

    public function contentDetail($id)
    {
        $content = Content::findOrfail($id);
        if ($content) {
            return view('admin.content.show', compact('content'));
        } else {
            return back()->with('Konten Tidak Ditemukan');
        }
    }

    public function updateContent(Request $request, $id)
    {
        $content = Content::findOrfail($id);
        $image = $content->image;
        if (!$content) {
            return back()->with('warning', 'Konten Tidak Ditemukan');
        }

        $validate = Validator::make($request->all(), [
            'editTitle' => 'required',
            'editBody' => 'required',
            'editImage' => 'nullable|mimes:png',
            'editStatus' => 'nullable',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Konten');
        }

        $newImage = $content->id . '.png';
        $content->title = $request->input('editTitle');
        $content->body = $request->input('editBody');
        $content->status = $request->input('editStatus') ? 1 : 0;
        if ($request->hasFile('editImage')) {
            Storage::delete('/public/content/' . $image);
            $request->file('editImage')->storeAs('content', $newImage);
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
            return redirect('/contents')->with('success', 'Berhasil Menghapus Konten');
        } else {
            return back()->with('warning', 'Konten Tidak Ditemukan');
        }
    }

    public function carouselPage()
    {
        $carousel = Content::where('category', '=', 'Carousel')->orderBy('created_at', 'DESC')->get();
        return view('admin.content.carousel.index', compact('carousel'));
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

    public function carouselDetail($id)
    {
        $carousel = Content::findOrfail($id);

        if ($carousel) {
            return view('admin.content.carousel.show', compact('carousel'));
        } else {
            return back()->with('warning', 'Data Tidak Ditemukan');
        }
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
