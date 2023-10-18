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

    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::findOrfail($user_id);
        $time = Carbon::now()->format('Y-m-d');
        $appointment = $user->appointment()->latest()->take(3)->get();
        $application = $user->applications()->with('loker')->latest()->take(2)->get();
        $sertifikat = $user->sertifikat()->latest()->take(2)->orderBy('created_at', 'DESC')->get();
        $pengalaman = $user->pengalaman()->latest()->take(2)->orderBy('created_at', 'DESC')->get();
        $loker = Loker::whereDate('deadline', '>=', $time)->where('status', '=', 'Open')->orderBy('created_at', 'asc')->with('employer')->take(3)->get();
        return view('user.index', compact('user', 'loker', 'appointment', 'application', 'sertifikat', 'pengalaman'));
    }

    public function indexProfile()
    {
        $year = date('Y');
        $minYear = $year - 15;
        $years = range($year, $minYear);
        $user_id = Auth::user()->id;
        $user = User::findOrfail($user_id);
        $pengalaman = $user->pengalaman()->take(5)->get();
        $pendidikan = Pendidikan::where('user_id', '=', $user_id)->OrderBy('created_at', 'DESC')->get();
        $pengalaman = Pengalaman::where('user_id', '=', $user_id)->OrderBy('created_at', 'DESC')->get();
        $sertifikasi = Sertifikasi::where('user_id', '=', $user_id)->OrderBy('created_at', 'DESC')->get();
        return view('user.profile.index', compact('user', 'years', 'pengalaman', 'sertifikasi'));
    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::user()->id;
        if (!$user_id) {
            return back()->with('warning', 'Terjadi Kesalahan');
        }
        $validate = Validator::make($request->all(), [
            'edit_nama' => 'required',
            'edit_email' => 'required',
            'edit_nomorTelepon' => 'required',
            'edit_tempatLahir' => 'required',
            'edit_tanggalLahir' => 'required|date',
            'edit_alamat' => 'required',
            'edit_kota' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Data');
        }

        $user = User::findOrfail($user_id);
        $user->nama_lengkap = $request->input('edit_nama');
        $user->alamat_email = $request->input('edit_email');
        $user->nomor_telepon = $request->input('edit_nomorTelepon');
        $user->tempat_lahir = $request->input('edit_tempatLahir');
        $user->tanggal_lahir = $request->input('edit_tanggalLahir');
        $user->alamat = $request->input('edit_alamat');
        $user->kota = $request->input('edit_kota');
        $user->update();
        return back()->with('success', 'Berhasil Mengubah Data Profile');
    }

    public function imgProfile(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::findOrfail($user_id);
        $profileImg = data_get($user, 'profile');
        $user_img = $request->file('profile_img');
        $validate = Validator::make($request->all(), [
            'profile_img' => 'required|mimes:png|max:10000'
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

    public function addSertifikat(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title_sertifikat' => 'required',
            'organisasi' => 'required',
            'bulan_terbit' => 'required',
            'tahun_terbit' => 'required',
            'bulan_berakhir' => 'required_with:tahun_berakhir',
            'tahun_berakhir' => 'required_with:bulan_berakhir',
            'id_sertifikat' => 'nullable',
            'url_sertifikat' => 'nullable',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Menambah Sertifikat Mohon Mengisi Ulang Form');
        }

        $sertifikat = new Sertifikasi;
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
        $sertifikat->save();
        return back()->with('success', 'Berhasil Menambah Sertikat');
    }

    public function indexSertifikat()
    {
        $year = date('Y');
        $minYear = $year - 15;
        $years = range($year, $minYear);
        $user = User::findOrFail(Auth::user()->id);
        $sertifikat = $user->sertifikat()->get();
        $new_sertifikat = collect();
        foreach ($sertifikat as $item) {
            $released_date = explode(' ', $item->tanggal_terbit);
            $released_month = $released_date[0];
            $released_year = intval($released_date[1]);
            if (!empty($item->tanggal_berakhir)) {
                $end_date = explode(' ', $item->tanggal_berakhir);
                $end_month = $end_date[0];
                $end_year = intval($end_date[1]);
                $newItem = (object)[
                    'id' => $item->id,
                    'title' => $item->title,
                    'organisasi' => $item->organisasi,
                    'bulan_terbit' => $released_month,
                    'tahun_terbit' => $released_year,
                    'tanggal_terbit' => $item->tanggal_terbit,
                    'bulan_berakhir' => $end_month,
                    'tahun_berakhir' => $end_year,
                    'tanggal_berakhir' => $item->tanggal_berakhir,
                    'id_sertifikat' => $item->id_sertifikat,
                    'url_sertifikat' => $item->url_sertifikat,
                ];
            }
            $newItem = (object)[
                'id' => $item->id,
                'title' => $item->title,
                'organisasi' => $item->organisasi,
                'bulan_terbit' => $released_month,
                'tahun_terbit' => $released_year,
                'tanggal_terbit' => $item->tanggal_terbit,
                'bulan_berakhir' => null,
                'tahun_berakhir' => null,
                'tanggal_berakhir' => null,
                'id_sertifikat' => $item->id_sertifikat,
                'url_sertifikat' => $item->url_sertifikat,
            ];
            $new_sertifikat->push($newItem);
        }
        return view('user.profile.sertifikat', compact('new_sertifikat', 'years'));
    }

    public function updateSertifikat(Request $request, $id)
    {
        $sertifikat = Auth::user()->sertifikat->find($id);
        if (!$sertifikat) {
            return back()->with('warning', 'Gagal Mengubah Data Sertifikat');
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

    public function deleteSertifikat($id)
    {
        $sertifikat = Auth::user()->sertifikat->find($id);
        if (!$sertifikat) {
            return back()->with('warning', 'Gagal Menghapus Sertifikat');
        }
        $sertifikat->delete();
        return back()->with('success', 'Berhasil Menghapus Sertifikat');
    }

    public function addPengalaman(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'jenis_pekerjaan' => 'required',
            'organisasi' => 'required',
            'lokasi_pekerjaan' => 'required',
            'bulan_mulai' => 'required',
            'tahun_mulai' => 'required',
            'bulan_selesai' => 'required_without_all: present_box',
            'tahun_selesai' => 'required_without_all: present_box',
            'present_box' => 'required_without_all: bulan_selesai, tahun_selesai',
            'deskripsi_pengalaman' => 'nullable',
        ]);


        if ($validate) {
            $pengalaman = new Pengalaman;
            if (empty($request->input('tahun_selesai')) && empty($request->input('bulan_selesai'))) {
                if (!$request->has('present_box')) {
                    return back()->with('warning', 'Mohon Mengisi Ulang Form');
                }
                $pengalaman->tanggal_selesai = 'Present';
            } else {
                $end_date = '01-' . str_pad($request->input('bulan_selesai'), 2, '0', STR_PAD_LEFT) . '-' . $request->input('tahun_selesai');
                $format_end_date = DateTime::createFromFormat('d-m-Y', $end_date);
                $tanggal_selesai = $format_end_date->format('F Y');
                $pengalaman->tanggal_selesai = $tanggal_selesai;
            }
            $start_date = '01-' . str_pad($request->input('bulan_mulai'), 2, '0', STR_PAD_LEFT) . '-' . $request->input('tahun_mulai');
            $format_start_date = DateTime::createFromFormat('d-m-Y', $start_date);
            $tanggal_mulai = $format_start_date->format('F Y');
            $pengalaman->title = $request->input('title');
            $pengalaman->jenis_pekerjaan = $request->input('jenis_pekerjaan');
            $pengalaman->organisasi = $request->input('organisasi');
            $pengalaman->lokasi_pekerjaan = $request->input('lokasi_pekerjaan');
            $pengalaman->deskripsi = $request->input('deskripsi_pengalaman');
            $pengalaman->tanggal_mulai = $tanggal_mulai;
            $pengalaman->user_id = Auth::user()->id;
            $pengalaman->save();
            return back()->with('success', 'Berhasil Menambah Data Pengalaman');
        } else {
            return back()->with('error', 'Mohon Mengisi Kembali Dengan Benar');
        }
    }

    public function updatePengalaman(Request $request, $id)
    {
        $pengalaman = Auth::user()->pengalaman->find($id);

        if (!$pengalaman) {
            return back()->with('warning', 'Data Pengalaman Tidak Ditemukan');
        }

        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'jenis_pekerjaan' => 'required',
            'organisasi' => 'required',
            'lokasi_pekerjaan' => 'required',
            'tanggal_mulai' => 'required',
            'bulan_selesai' => 'required_without_all: present_box',
            'tahun_selesai' => 'required_without_all: present_box',
            'present_box' => 'required_without_all: bulan_selesai, tahun_selesai',
            'deskripsi_pengalaman' => 'nullable',
        ]);
        if ($validate->fails()) {
            return back()->with('warning', 'Gagal Mengubah Data Pengalaman');
        }

        if (empty($request->input('tahun_selesai')) && empty($request->input('bulan_selesai'))) {
            $pengalaman->tanggal_selesai = $request->input('present_box');
        } else {
            $end_date = '01-' . str_pad($request->input('bulan_selesai'), 2, '0', STR_PAD_LEFT) . '-' . $request->input('tahun_selesai');
            $format_end_date = DateTime::createFromFormat('d-m-Y', $end_date);
            $tanggal_selesai = $format_end_date->format('F Y');
            $pengalaman->tanggal_selesai = $tanggal_selesai;
        }
        $start_date = '01-' . str_pad($request->input('bulan_mulai'), 2, '0', STR_PAD_LEFT) . '-' . $request->input('tahun_mulai');
        $format_start_date = DateTime::createFromFormat('d-m-Y', $start_date);
        $tanggal_mulai = $format_start_date->format('F Y');
        $pengalaman->title = $request->input('title');
        $pengalaman->jenis_pekerjaan = $request->input('jenis_pekerjaan');
        $pengalaman->organisasi = $request->input('organisasi');
        $pengalaman->lokasi_pekerjaan = $request->input('lokasi_pekerjaan');
        $pengalaman->deskripsi = $request->input('deskripsi_pengalaman');
        $pengalaman->tanggal_mulai = $tanggal_mulai;
        $pengalaman->user_id = Auth::user()->id;
        $pengalaman->save();
        return back()->with('success', 'Berhasil Mengubah Data Pengalaman');
    }

    public function indexPengalaman()
    {
        $year = date('Y');
        $minYear = $year - 15;
        $years = range($year, $minYear);
        $user = User::findOrfail(Auth::user()->id);
        $pengalaman = $user->pengalaman()->get();
        $new_Pengalaman = collect();
        foreach ($pengalaman as $item) {
            $start_date = explode(' ', $item->tanggal_mulai);
            $start_month = $start_date[0];
            $start_year = intval($start_date[1]);
            if ($item->tanggal_selesai === 'Present') {
                $end_date = True;
                $newItem = (object)[
                    'id' => $item->id,
                    'title' => $item->title,
                    'jenis_pekerjaan' => $item->jenis_pekerjaan,
                    'organisasi' => $item->organisasi,
                    'lokasi_pekerjaan' => $item->lokasi_pekerjaan,
                    'tanggal_mulai' => $item->tanggal_mulai,
                    'bulan_mulai' => $start_month,
                    'tahun_mulai' => $start_year,
                    'tanggal_selesai' => $item->tanggal_selesai,
                    'bulan_selesai' => null,
                    'tahun_selesai' => null,
                    'present' => $end_date,
                    'deskripsi' => $item->deskripsi,
                    'user_id' => $item->user_id,
                ];
            } else {
                $end_date = explode(' ', $item->tanggal_selesai);
                $end_month = $end_date[0];
                $end_year = intval($end_date[1]);
                $newItem = (object)[
                    'id' => $item->id,
                    'title' => $item->title,
                    'jenis_pekerjaan' => $item->jenis_pekerjaan,
                    'organisasi' => $item->organisasi,
                    'lokasi_pekerjaan' => $item->lokasi_pekerjaan,
                    'tanggal_mulai' => $item->tanggal_mulai,
                    'bulan_mulai' => $start_month,
                    'tahun_mulai' => $start_year,
                    'tanggal_selesai' => $item->tanggal_selesai,
                    'bulan_selesai' => $end_month,
                    'tahun_selesai' => $end_year,
                    'present' => null,
                    'deskripsi' => $item->deskripsi,
                    'user_id' => $item->user_id,
                ];
            }
            $new_Pengalaman->push($newItem);
        }
        return view('user.profile.pengalaman', compact('new_Pengalaman', 'years'));
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
        $auth = Auth::user();
        $user = User::findOrfail($auth->id);
        $pending = $user->where('status', 'Pending');
        $loker = Loker::findorfail($id);
        if (!$user->profile || !$user->resume) {
            return back()->with('warning', 'Mohon Melengkapi Data Profile Terlebih Dahulu');
        }
        if ($loker->applicants()->where('user_id', $auth->id)->exists()) {
            return back()->with('warning', 'Lamaran Sudah Pernah Dimasukkan');
        }
        if ($pending > 5) {
            return back()->with('warning', 'Telah Mencapai Batas Untuk Melakukan Pelamaran');
        }
        $application = new Application;
        $application->user_id = $auth->id;
        $application->loker_id = $id;
        $application->status = 'Pending';
        $application->save();
        return back()->with('success', 'Lamaran Telah Dimasukkan');
    }

    public function indexAppointment()
    {
        $user_id = Auth::user()->id;
        $appointment = Appointment::where('user_id', '=', $user_id)->orderBy('created_at', 'DESC')->get();
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
            'tempat_konseling' => 'required',
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
            $appointment->tempat_konseling = $request->input('tempat_konseling');
            $appointment->status = 'Pending';
            if (Appointment::where('date_time', '=', $merge)->exists()) {
                return back()->with('warning', 'Tanggal dan Jam Sudah Terisi Mohon Mengganti Jadwal');
            } else {
                $appointment->save();
                return redirect('/Home/User/Appointment')->with('success', 'Jadwal konseling berhasil dibuat, mohon menunggu konfirmasi email dari pusat karir ITK, Terimakasih');
            }
        } else {
            return back()->with('warning', 'Mohon memasukkan ulang form');
        }
    }

    public function detailAppointment($id)
    {
        $user = Auth::user();
        $appointments = $user->appointment;
        $appointment = $appointments->firstWhere('id', $id);
        if ($appointment) {
            return view('user.consult.detail', compact('appointment'));
        }

        return $appointments;
    }

    public function editAppointment(Request $request, $id)
    {
        $user = Auth::user();
        $appointments = $user->appointment;
        $appointment = $appointments->firstWhere('id', $id);
        if ($appointment) {
            $validate = Validator::make($request->all(), [
                'tempat_konseling' => 'required',
                'jam_konseling' => 'required',
                'tanggal_konseling' => 'required',
            ]);
            if ($validate) {
                $appointment->tempat_konseling = $request->input('tempat_konseling');
                $date = $request->input('tanggal_konseling');
                $jam = $request->input('jam_konseling');
                $merge = new DateTime($date . ' ' . $jam);
                $appointment->date_time = $merge;
                $appointment->status = 'Rearranged';
                if ($appointment->status === 'Reschedule') {
                    $appointment->update();
                } else {
                    return back()->with('warning', 'Appointment Sedang Dalam Status Pending, Mohon Menunggu Respon Admin');
                }
                return back()->with('success', 'Berhasil Mengubah Waktu dan Tanggal Appointment');
            } else {
                return back()->with('warning', 'Mohon Mengisi Ulang Form');
            }
        } else {
            return redirect('/Home/User/Appointment')->with('warning', 'Appointment Tidak Ditemukan');
        }
    }
}
