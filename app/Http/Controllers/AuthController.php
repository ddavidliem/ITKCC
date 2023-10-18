<?php


namespace App\Http\Controllers;



use App\Mail\ResetMail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employer;
use App\Models\Approval;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Prodi;
use App\Mail\EmailVerification;
use App\Mail\ResetPassword;
use App\Mail\ApprovalNotification;



class AuthController extends Controller
{
    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    public function indexVerification()
    {
        return view('auth.verification.index');
    }

    public  function UserRegForm()
    {
        $prodi = Prodi::get();
        return view('auth.register.user', compact('prodi'));
    }

    public function UserReg(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'nama_lengkap' => 'required',
            'alamat_email' => 'required|unique:users,alamat_email|email',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date|',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'kode_pos' => 'required',
            'nomor_telepon' => 'required|unique:users,nomor_telepon',
            'kewarganegaraan' => 'required',
            'status_perkawinan' => 'required',
            'agama' => 'required',
            'pendidikan' => 'required',
            'nim' => 'nullable',
            'ipk' => 'nullable',
            'program_studi' => 'required',
            'disabilitas' => 'nullable',
            'captcha' => 'required|captcha',
        ]);

        if ($validate->fails()) {
            if ($request->input('username') && User::where('username', $request->input('username'))->exists()) {
                return back()->with('warning', 'Username telah digunakan, Gunakan Username Lain');
            }
            if ($request->input('alamat_email') && User::where('alamat_email', $request->input('alamat_email'))->exists()) {
                return back()->with('warning', 'Alamat Email Telah Digunakan, Gunakan Email Lain, Atau Lakukan Verifikasi Email');
            }
            return back()->with('warning', 'Terjadi Kesalahan Pada Pengisian Formulir Pastikan Password dan Captcha Di Masukkan dengan Benar')->withInput();
        }

        $user = new User;
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->nama_lengkap = $request->input('nama_lengkap');
        $user->alamat_email = $request->input('alamat_email');
        $user->tempat_lahir = $request->input('tempat_lahir');
        $user->tanggal_lahir = $request->input('tanggal_lahir');
        $user->jenis_kelamin = $request->input('jenis_kelamin');
        $user->alamat = $request->input('alamat');
        $user->kota = $request->input('kota');
        $user->kode_pos = $request->input('kode_pos');
        $user->nomor_telepon = $request->input('nomor_telepon');
        $user->kewarganegaraan = $request->input('kewarganegaraan');
        $user->status_perkawinan = $request->input('status_perkawinan');
        $user->agama = $request->input('agama');
        $user->pendidikan_tertinggi = $request->input('pendidikan');
        $user->nim = $request->input('nim');
        $user->ipk = $request->input('ipk');
        $user->program_studi = $request->input('program_studi');
        $user->disabilitas = $request->input('disabilitas');
        $user->email_verification = null;
        $user->save();

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
            'user_id' => $user->id,
            'category' => 'user',
            'token' => $token,
            'type' => 'email_verification',
            'expires_at' => now()->addMinutes(15),
        ]);

        Mail::to($user->alamat_email)->send(new EmailVerification($user, $token));
        return redirect('/')->with('success', 'Akun Berhasil Dibuat. Mohon Lakukan Verifikasi Email');
    }

    public function emailVerify($token)
    {
        $tokenRecord = DB::table('tokens')->where('token', $token)
            ->where('type', 'email_verification')
            ->where('expires_at', '>', now())->first();

        if (!$tokenRecord) {
            return redirect('/')->with('warning', 'Link Verifikasi telah Expired atau Invalid');
        }

        $user = User::find($tokenRecord->user_id);
        $user->email_verification = now();
        $user->save();
        $tokenRecord = DB::table('tokens')->where('token', $token)->delete();
        return redirect('/')->with('success', 'Email Telah Diverifkasi Silahkan Melakukan Login');
    }

    public function resendVerificationMail(Request $request)
    {
        $validate = Validator::make($request->all, [
            'kategori' => 'required|in:user,employer',
            'alamat_email' => 'required|email',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Mohon Mengisi Ulang Form Dengan Benar');
        }
        $model = $request->input('kategori') === 'user' ? User::class : Employer::class;
        $user = $model::where('alamat_email', $request->input('alamat_email'))->first();
        if (!$user || $user->email_verification !== null) {
            return back()->with('warning', 'Email Sudah Terverifikasi');
        }
        $tokenExists = true;
        $token = null;
        while ($tokenExists) {
            $token = Str::random(64);
            $existingToken = DB::table('tokens')->where('token', $token)->first();
            if (!$existingToken) {
                $tokenExists = false;
            }
        }
        DB::table('tokens')->where('user_id', '=', $user->id)
            ->where('category', $request->input('kategori'))
            ->where('type', $request->input('alamat_email'))
            ->update([
                'token' => $token,
                'expires_at' => now()->addMinutes(10),
            ]);
        Mail::to($user->alamat_email)->send(new EmailVerification($user, $token));
        return back()->with('success', 'Link Verifikasi Telah Dikirim');
    }

    public function UserLoginForm()
    {
        return view('auth.login.user');
    }

    public function UserLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $logintype = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'alamat_email' : 'username';
        if (Auth::guard('user')->attempt([$logintype => $request->username, 'password' => $request->password])) {
            return redirect()->intended('/Home/User');
        } else {
            return back()->with('error', 'username atau password salah/tidak terdaftar');
        }
    }

    public function EmployerLoginForm()
    {
        return view('auth.login.employer');
    }

    public function EmployerLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('employer')->attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended('/Employer/Dashboard');
        } else {
            return back()->with('error', 'username atau password salah / tidak terdaftar');
        }
    }

    public function EmployerRegForm()
    {
        return view('auth.register.employer');
    }

    public function EmployerApproval(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|unique:employers,username',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'nama_perusahaan' => 'required|unique:employers,nama_perusahaan',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kode_pos' => 'required',
            'website' => 'nullable',
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
            'nomor_telepon' => [
                'required|unique:employers,nomor_telepon',
                Rule::unique('approvals', 'nomor_telepon')->where(function ($query) {
                    $query->where('status', 'approved');
                }),
            ],
            'alamat_email' => [
                'required|unique:employers,alamat_email',
                Rule::unique('approvals', 'alamat_email')->where(function ($query) {
                    $query->where('status', 'approved');
                }),
            ],
            'formulir' => 'required|mimes:pdf|max:10000',
            'captcha' => 'required|captcha',
        ]);

        if ($validate->fails()) {
            return back()->with('warning', 'Mohon Mengisi Ulang Form Dengan Benar')->withErrors($validate)->withInput();
        }


        $approval = new Approval();
        $approval->username = $request->input('username');
        $approval->password = Hash::make($request->input('password'));
        $approval->nama_perusahaan = $request->input('nama_perusahaan');
        $approval->alamat = $request->input('alamat');
        $approval->provinsi = $request->input('provinsi');
        $approval->kota = $request->input('kota');
        $approval->kode_pos = $request->input('kode_pos');
        $approval->website = $request->input('website');
        $approval->nama_lengkap = $request->input('nama_lengkap');
        $approval->jabatan = $request->input('jabatan');
        $approval->nomor_telepon = $request->input('nomor_telepon');
        $approval->alamat_email = $request->input('alamat_email');
        $approval->status = 'pending';

        $formulir_name = $approval->id . '.' . 'pdf';
        $approval->formulir = $formulir_name;
        $approval->save();
        $request->file('formulir')->storeAs('formulir', $formulir_name);

        Mail::to($approval->alamat_email)->send(new ApprovalNotification($approval));
        return redirect('/')->with('success', 'Permohonan Telah Dibuat, Periksa Kotak Email Untuk Melihat Detail Permohonan');
    }


    public function templateDownload()
    {
        $template = public_path('/test/path');
        return response()->download($template, 'Formulir-Pendaftaran');
    }

    public function resetPasswordIndex()
    {
        return view('auth.password.index');
    }

    public function resetPasswordMail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'kategori' => 'required|in:user,employer',
            'alamat_email' => 'required|email',
        ]);
        if ($validate->fails()) {
            return back()->with('warning', 'Masukkan Ulang Form');
        }
        $model = $request->input('kategori') === 'user' ? User::class : Employer::class;
        $user = $model::where('alamat_email', $request->input('alamat_email'))->where('email_verification', true)->first();
        if (!$user) {
            return back()->with('warning', 'Email Tidak Ditemukan Atau Belum Terverifikasi');
        }
        $tokenExists = true;
        $token = null;
        while ($tokenExists) {
            $token = Str::random(64);
            $existingToken = DB::table('tokens')->where('token', $token)->first();
            if (!$existingToken) {
                $tokenExists = false;
            }
        }
        $record = DB::table('tokens')->where('user_id', $user->id)->where('type', 'reset_password')->first();
        if ($record) {
            DB::table('tokens')->where('user_id', $user->id)
                ->where('type', 'reset_password')
                ->update([
                    'token' => $token,
                    'expires_at' => now()->addMinutes(15),
                ]);
        } else {
            DB::table('tokens')->insert([
                'user_id' => $user->id,
                'category' => 'user',
                'token' => $token,
                'type' => 'reset_password',
                'expires_at' => now()->addMinutes(15),
            ]);
        }
        Mail::to($user->alamat_email)->send(new ResetPassword($user, $token));
        return back()->with('success', 'Link Reset Password Telah Dikirim');
    }

    public function adminLoginForm()
    {
        return view('auth.login.admin');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended('/dashboard');
        } else {
            return back()->with('error', 'username atau password salah / tidak terdaftar');
        }
    }
}
