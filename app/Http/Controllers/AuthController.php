<?php


namespace App\Http\Controllers;



use App\Mail\ResetMail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employer;
use App\Models\Approval;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;



use function PHPSTORM_META\map;

class AuthController extends Controller
{
    public  function UserRegForm()
    {
        return view('auth.register-user');
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
            'nomor_ktp' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'kode_pos' => 'required',
            'nomor_telepon' => 'required',
            'kewarganegaraan' => 'required',
            'status_perkawinan' => 'required',
            'agama' => 'required',
            'pendidikan_tertinggi',
            'nim' => 'nullable',
            'ipk' => 'nullable',
            'bidang' => 'required',
            'disabilitas' => 'nullable',
            'captcha' => 'required|captcha',
        ]);

        if ($validate->fails()) {
            return Redirect::back()->withErrors($validate);
        } else {
            $user = new User;
            $user->username = $request->input('username');
            $user->password = Hash::make($request->input('password'));
            $user->nama_lengkap = $request->input('nama_lengkap');
            $user->alamat_email = $request->input('alamat_email');
            $user->tempat_lahir = $request->input('tempat_lahir');
            $user->tanggal_lahir = $request->input('tanggal_lahir');
            $user->nomor_ktp = $request->input('nomor_ktp');
            $user->jenis_kelamin = $request->input('jenis_kelamin');
            $user->alamat = $request->input('alamat');
            $user->kota = $request->input('kota');
            $user->kode_pos = $request->input('kode_pos');
            $user->nomor_telepon = $request->input('nomor_telepon');
            $user->kewarganegaraan = $request->input('kewarganegaraan');
            $user->status_perkawinan = $request->input('status_perkawinan');
            $user->agama = $request->input('agama');
            $user->pendidikan_tertinggi = $request->input('pendidikan_tertinggi');
            $user->nim = $request->input('nim');
            $user->ipk = $request->input('ipk');
            $user->bidang = $request->input('bidang');
            $user->disabilitas = $request->input('disabilitas');
            $user->save();
            return redirect('/')->with('success', 'Berhasil membuat akun user');
        }
    }

    public function UserLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('user')->attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended('/Home/User');
        } else {
            return back()->with('error', 'username atau password salah/tidak terdaftar');
        }
    }

    public function ForgetPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function submitForgetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,alamat_email',
        ]);
        $token = Str::random(24);

        if ($validate->fails()) {
            redirect('/')->with('error', 'Email Tidak Terdaftar');
        } else {
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            Mail::send('auth.reset-password-link', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });
            return back()->with('success', 'Link Mengubah Password telah dikirim ke email');
        }
    }

    public function ResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function submitResetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,alamat_email',
            'reset_password' => 'required',
            'reset_password_confirmation' => 'required|same:reset_password',
        ]);

        if ($validate->fails()) {
            return Redirect::back()->withErrors($validate);
        } else {
            $updatePassword = DB::table('password_resets')
                ->where([
                    'email' => $request->email,
                    'token' => $request->token
                ])->first();

            if (!$updatePassword) {
                return back()->withInput()->with('error', 'Invalid token!');
            } else {
                User::where('alamat_email', $request->email)->update(['password' => Hash::make($request->reset_password)]);

                DB::table('password_resets')->where(['email' => $request->email])->delete();
                return redirect('/Home/User')->with('success', 'Password Telah Diubah');
            }
        }
    }

    public function EmployerLoginForm()
    {
        return view('auth.login-employer');
    }

    public function EmployerRegForm()
    {
        return view('auth.register-employer');
    }

    public function EmployerApproval(Request $request)
    {
        $approval_formulir = $request->file('formulir');
        $validate = Validator::make($request->all(), [
            'username' => 'required|unique:employers,username',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'nama_perusahaan' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kode_pos' => 'required',
            'website' => 'nullable',
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
            'nomor_telepon' => 'required',
            'alamat_email' => 'required|email|unique:employers,alamat_email',
            'formulir' => 'required|mimes:pdf|max:10000',
            'captcha' => 'required|captcha',
        ]);

        if ($validate->fails()) {
            return Redirect::back()->withErrors($validate);
        } else {
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
            $approval->status = 'Pending';
            $name = Str::random(21);
            $formulir_id = $name . '.' . 'pdf';
            $approval->formulir = $formulir_id;
            $approval->save();
            $approval_formulir->storeAs('formulir', $formulir_id);
            return redirect('/')->with('success', 'Berhasil Membuat Akun Permohonan Mohon Menunggu Persetujuan Dari Admin');
        }
    }

    // public function EmployerReg(Request $request)
    // {
    //     $validate = Validator::make($request->all(), [
    //         'username' => 'required|unique:employers,username',
    //         'password' => 'required|min:8',
    //         'password_confirmation' => 'required|same:password',
    //         'nama_perusahaan' => 'required',
    //         'alamat' => 'required',
    //         'provinsi' => 'required',
    //         'kota' => 'required',
    //         'kode_pos' => 'required',
    //         'website' => 'nullable',
    //         'nama_lengkap' => 'required',
    //         'jabatan' => 'required',
    //         'nomor_telepon' => 'required',
    //         'alamat_email' => 'required|email|unique:employers,alamat_email',
    //         'captcha' => 'required|captcha',
    //     ]);

    //     if ($validate->fails()) {
    //         return Redirect::back()->withErrors($validate);
    //     } else {
    //         $employer = new Employer;
    //         $employer->username = $request->input('username');
    //         $employer->password = Hash::make($request->input('password'));
    //         $employer->nama_perusahaan = $request->input('nama_perusahaan');
    //         $employer->alamat = $request->input('alamat');
    //         $employer->provinsi = $request->input('provinsi');
    //         $employer->kota = $request->input('kota');
    //         $employer->kode_pos = $request->input('kode_pos');
    //         $employer->website = $request->input('website');
    //         $employer->nama_lengkap = $request->input('nama_lengkap');
    //         $employer->jabatan = $request->input('jabatan');
    //         $employer->nomor_telepon = $request->input('nomor_telepon');
    //         $employer->alamat_email = $request->input('alamat_email');
    //         $employer->save();
    //         return redirect('/')->with('success', 'Berhasil Membuat Akun Employer');
    //     }
    // }

    public function EmployerLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('employer')->attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended('/employer/dashboard');
        } else {
            return back()->with('error', 'username atau password salah / tidak terdaftar');
        }
    }

    public function EmployerForgetPasswordForm()
    {
        return view();
    }

    public function EmployerForgetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), []);

        $token = Str::random(24);

        if ($validate->fails()) {
            redirect('/')->with('error', 'Email tidak terdaftar');
        } else {
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            Mail::send('auth.reset-password-link', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password Link');
            });
            return back()->with('success', 'Link Mengubah Password Telah Di Kirim ke Email');
        }
    }

    public function EmployerResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function EmployerResetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'reset_password' => 'required',
            'reset_password_confirmation' => 'required',
        ]);

        if ($validate->fails()) {
            return Redirect::back()->withErrors($validate);
        } else {
            $updatePassword = DB::table('password_resets')
                ->where([
                    'email' => $request->email,
                    'token' => $request->token
                ])->first();

            if (!$updatePassword) {
                return back()->withInput()->with('error', 'Invalid Token');
            } else {
                User::where('alamat_email', $request->email)->update(['password' => Hash::make($request->reset_password)]);
                DB::tabel('password_resets')->where(['email' => $request->email])->delete();
                return redirect('/Dashboard/Employer')->with('sucess', 'Password Telah Di Ubah');
            }
        }
    }

    public function adminLoginForm()
    {
        return view('auth.login-admin');
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
