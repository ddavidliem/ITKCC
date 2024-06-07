<?php


namespace App\Http\Controllers;



use App\Mail\ResetMail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employer;
use App\Models\Approval;
use App\Models\Topic;
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
use Illuminate\Support\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function redirectGoogle($type)
    {
        session(['google_login_type' => $type]);
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $type = session('google_login_type');
            switch ($type) {
                case 'user':
                    $loginUser = User::where('alamat_email', $user->email)->first();
                    if (!$loginUser) {
                        return redirect('/login/user')->with('warning', 'Gagal Melakukan Login');
                    }
                    if ($loginUser->email_verification === null) {
                        return redirect('/login/user')->with('warning', 'Email Belum Terverifikasi');
                    }
                    Auth::guard('user')->login($loginUser);
                    $loginUser->google_id = $user->getId();
                    $loginUser->save();
                    return redirect()->intended(route('user.index'));
                    break;
                case 'employer':
                    $loginEmployer = Employer::where('alamat_email', $user->email)->first();
                    if (!$loginEmployer) {
                        return redirect('/login/employer')->with('warning', 'Gagal Melakukan Login');
                    }
                    if ($loginEmployer->email_verification === null) {
                        return redirect('/login/employer')->with('warning', 'Email Belum Terverifikasi');
                    }
                    Auth::guard('employer')->login($loginEmployer);
                    $loginEmployer->google_id = $user->getId();
                    $loginEmployer->save();
                    return redirect()->intended(route('employer.index'));
                    break;
            }
        } catch (Exception $e) {
            Log::error('Google callback error: ' . $e->getMessage());
            return redirect('/')->withErrors(['warning' => 'Terjadi kesalahan Saat Terhubung Google']);
        }
    }

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
            'username' => 'required|string|min:5|max:64|unique:users,username',
            'password' => 'required|confirmed|min:8|max:32',
            'password_confirmation' => 'required|same:password',
            'nama_lengkap' => 'required|string|min:3|max:128',
            'alamat_email' => 'required|unique:users,alamat_email|email|regex:/@gmail\.com$/i|min:8|max:128',
            'tempat_lahir' => 'required|string|min:4|max:64',
            'tanggal_lahir' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'jenis_kelamin' => 'required|string|in:pria,wanita',
            'alamat' => 'required|string|min:8|max:512',
            'kota' => 'required|string|min:4|max:64',
            'kode_pos' => 'required|digits_between:4,6',
            'nomor_telepon' => 'required|numeric|digits_between:8,14|unique:users,nomor_telepon',
            'kewarganegaraan' => 'required|string|max:8',
            'status_perkawinan' => 'required|string|min:4|max:32',
            'agama' => 'required|string|min:4|max:24',
            'pendidikan' => 'required|string|max:24',
            'nim' => 'nullable|digits_between:8,12',
            'ipk' => 'nullable|numeric|between:0,4',
            'program_studi' => 'required|string|min:4|max:32',
            'disabilitas' => 'nullable|string|min:4|max:64',
            'captcha' => 'required|captcha',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
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
        $user->status = 'active';
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
            'alamat_email' => $request->input('alamat_email'),
            'expires_at' => now()->addMinutes(15),
        ]);

        Mail::to($user->alamat_email)->send(new EmailVerification($user, $token));
        return redirect('/')->with('success', 'Akun Berhasil Dibuat. Mohon Periksa Kotak Email Untuk Melakukan Verifikasi Email');
    }

    public function emailVerify($token)
    {
        $tokenRecord = DB::table('tokens')->where('token', $token)
            ->where('type', 'email_verification')
            ->where('expires_at', '>', now())->first();
        if (!$tokenRecord) {
            return redirect('/')->with('warning', 'Link Verifikasi Email Telah Expired atau Invalid');
        }

        $model = $tokenRecord->category === 'user' ? User::class : Employer::class;
        $user = $model::find($tokenRecord->user_id);
        $user->email_verification = now();
        $user->save();
        DB::table('tokens')->where('token', $token)->delete();
        return redirect('/')->with('success', 'Email Telah Terverifikasi Silahkan Melakukan Login');
    }

    public function resendVerificationMail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'kategori' => 'required|in:user,employer|max:16',
            'alamat_email' => 'required|email|regex:/@gmail\.com$/i|min:8|max:128',
            'captcha' => 'required|captcha',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate);
        }

        $model = $request->input('kategori') === 'user' ? User::class : Employer::class;
        $user = $model::where('alamat_email', $request->input('alamat_email'))->first();

        if (!$user || $user->email_verification !== null) {
            return back()->with('warning', 'Email Tidak Terdaftar Atau Sudah Terverifikasi');
        }

        if ($user->status == 'suspended') {
            return back()->with('warning', 'Tidak Dapat Melakukan Verifikasi Email');
        }

        DB::table('tokens')->where('user_id', $user->id)
            ->where('category', $request->input('kategori'))
            ->where('type', 'email_verification')
            ->delete();

        $token = Str::random(64);
        $expiresAt = now()->addMinutes(15);

        DB::table('tokens')->insert([
            'user_id' => $user->id,
            'alamat_email' => $user->alamat_email,
            'category' => $request->input('kategori'),
            'token' => $token,
            'type' => 'email_verification',
            'expires_at' => $expiresAt,
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
        $user = User::where($logintype, $request->username)->first();
        if (!$user) {
            return back()->with('warning', 'username dan password salah');
        }
        if ($user->email_verification === null) {
            return back()->with('warning', 'Email Belum Terverifikasi');
        }
        if ($user->status == 'suspended') {
            return back()->with('warning', 'Tidak Dapat Melakukan Login');
        }
        if (Auth::guard('user')->attempt([$logintype => $request->username, 'password' => $request->password])) {
            return redirect()->intended(route('user.index'));
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
        $logintype = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'alamat_email' : 'username';
        $employer = Employer::where($logintype, $request->username)->first();
        if (!$employer) {
            return back()->with('warning', 'Username Tidak Ditemukan, Username dan Password Tidak Sama');
        }
        if ($employer->email_verification === null) {
            return back()->with('warning', 'Email Belum Terverifikasi');
        }
        if ($employer->status == 'suspended') {
            return back()->with('warning', 'Tidak Bisa Melakukan Login, Mohon Menghubungi Tim Pusat Karir ITK');
        }
        if (Auth::guard('employer')->attempt([$logintype => $request->username, 'password' => $request->password])) {
            return redirect()->intended(route('employer.index'));
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
            'username' => 'required|string|min:5|max:64|unique:employers,username',
            'password' => 'required|min:8|max:32',
            'password_confirmation' => 'required|same:password|min:8|max:64',
            'nama_perusahaan' => 'required|unique:employers,nama_perusahaan|min:4|max:128',
            'alamat' => 'required|string|min:8|max:512',
            'provinsi' => 'required|string|min:4|max:64',
            'kota' => 'required|string|min:4|max:64',
            'kode_pos' => 'required|integer|digits_between:4,6',
            'website' => 'nullable|url|min:4|max:128',
            'bidang_perusahaan' => 'required|string|min:4|max:128',
            'tahun_berdiri' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'kantor_pusat' => 'required|string|min:8|max:256',
            'nama_lengkap' => 'required|string|min:4|max:128',
            'jabatan' => 'required|string|min:4|max:128',
            'nomor_telepon' => 'required|digits_between:12,32|unique:approvals,nomor_telepon,NULL,id,status,approved',
            'alamat_email' => 'required|string|email|min:4|max:128|unique:approvals,alamat_email,NULL,id,status,approved|regex:/@gmail\.com$/i',
            'formulir' => 'required|file|mimes:pdf|max:2048',
            'captcha' => 'required|captcha',
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
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
        $approval->bidang_perusahaan = $request->input('bidang_perusahaan');
        $approval->tahun_berdiri = $request->input('tahun_berdiri');
        $approval->kantor_pusat = $request->input('kantor_pusat');
        $approval->nama_lengkap = $request->input('nama_lengkap');
        $approval->jabatan = $request->input('jabatan');
        $approval->nomor_telepon = $request->input('nomor_telepon');
        $approval->alamat_email = $request->input('alamat_email');
        $approval->status = 'pending';

        $formulir_name = $approval->id . '.' . 'pdf';
        $approval->formulir = $formulir_name;
        $approval->save();
        $request->file('formulir')->storeAs('formulir', $formulir_name);

        $subject = 'Notifikasi: Pembuatan Akun Perusahaan';
        $template = 'auth.mail.approval-new';
        $feedback = "";
        Mail::to($approval->alamat_email)->send(new ApprovalNotification($subject, $approval, $template, $feedback));
        return redirect('/')->with('success', 'Permohonan Telah Dibuat, Periksa Kotak Email / Spam Untuk Melihat Detail Permohonan');
    }


    public function forgotPasswordIndex()
    {
        return view('auth.password.index');
    }

    public function resetPasswordMail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'kategori' => 'required|in:user,employer',
            'alamat_email' => 'required|email|min:8|max:128|regex:/@gmail\.com$/i',
            'captcha' => 'required|captcha',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate);
        }
        $model = $request->input('kategori') === 'user' ? User::class : Employer::class;
        $user = $model::where('alamat_email', $request->input('alamat_email'))->whereNotNull('email_verification')->first();
        if (!$user) {
            return back()->with('warning', 'Email Tidak Ditemukan Atau Belum Terverifikasi');
        }
        if ($user->status == 'suspended') {
            return back()->with('warning', 'Akun ini Tidak Dapat Mengubah Password');
        }
        $token = Str::uuid()->toString();
        while (DB::table('tokens')->where('token', $token)->exists()) {
            $token = Str::uuid()->toString();
        }
        $record =  DB::table('tokens')->where('user_id', $user->id)->where('type', 'reset_password')->first();
        $tokenData = [
            'user_id' => $user->id,
            'alamat_email' => $user->alamat_email,
            'category' => $request->input('kategori'),
            'token' => $token,
            'type' => 'reset_password',
            'expires_at' => now()->addMinutes(15),
        ];
        if ($record) {
            DB::table('tokens')->where('user_id', $user->id)
                ->where('type', 'reset_password')
                ->update($tokenData);
        } else {
            DB::table('tokens')->insert($tokenData);
        }

        try {
            Mail::to($user->alamat_email)->send(new ResetPassword($user, $token));
            return back()->with('success', 'Link Reset Password Telah Dikirim');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email reset password');
        }
    }

    public function resetPasswordForm()
    {
        $token = request()->route('token');
        return view('auth.password.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $token = $request->input('token');
        $checkToken = DB::table('tokens')->where('token', $token)->where('type', 'reset_password')->exists();
        if (!$checkToken) {
            return back()->with('warning', 'Token Tidak Valid');
        }
        $token = DB::table('tokens')->where('token', $token)->where('type', 'reset_password')->first();
        $expire = Carbon::parse($token->expires_at);
        if ($expire->isPast()) {
            return back()->with('warning', 'Token Sudah Tidak Berlaku');
        }
        $validate = Validator::make($request->all(), [
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate);
        }
        $model = $token->category === 'user' ? User::class : Employer::class;
        $user = $model::findOrfail($token->user_id);
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        DB::table('tokens')->where('token', $token->token)->delete();
        return redirect('/')->with('success', 'Password Berhasil Direset. Silahkan melakukan login dengan password baru');
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
            return redirect()->intended(route('admin'));
        } else {
            return back()->with('error', 'username atau password salah / tidak terdaftar');
        }
    }
}
