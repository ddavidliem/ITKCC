<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\EmployerResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class DataController extends Controller
{

    public function getUserData()
    {
        $users = User::whereNotNull('nim')->get();
        return UserResource::collection($users);
    }

    public function getEmployerData()
    {
        $employers = Employer::whereNotNull('email_verification')->get();
        return EmployerResource::collection($employers);
    }

    public function importUser(Request $request)
    {
        Validator::make($request->all(), [
            'users' => 'required|array',
            'users.*.username' => 'required|string|max:16',
            'users.*.password' => 'required',
            'users.*.alamat_email' => 'required|email|unique:users,alamat_email',
            'users.*.nama_lengkap' => 'required|string',
            'users.*.tempat_lahir' => 'required|string',
            'users.*.tanggal_lahir' => 'required|date',
            'users.*.jenis_kelamin' => 'required|string',
            'users.*.alamat' => 'required|max:160',
            'users.*.kota' => 'required|string',
            'users.*.kode_pos' => 'required|string',
            'users.*.nomor_telepon' => 'required|string',
            'users.*.kewarganegaraan' => 'required|string',
            'users.*.status_perkawinan' => 'required',
            'users.*.agama' => 'required',
            'users.*.pendidikan' => 'required',
            'users.*.nim' => 'nullable',
            'users.*.ipk' => 'nullable',
            'users.*.program_studi' => 'required',
            'users.*.disabilitas' => 'nullable',
        ]);

        try {
            DB::beginTransaction();
            $createdUsers = [];

            foreach ($request->input('users') as $userData) {
                $user = new User;
                $user->username = $userData['username'];
                $user->password = Hash::make($userData['password']);
                $user->nama_lengkap = $userData['nama_lengkap'];
                $user->alamat_email = $userData['alamat_email'];
                $user->tempat_lahir = $userData['tempat_lahir'];
                $user->tanggal_lahir = $userData['tanggal_lahir'];
                $user->jenis_kelamin = $userData['jenis_kelamin'];
                $user->alamat = $userData['alamat'];
                $user->kota = $userData['kota'];
                $user->kode_pos = $userData['kode_pos'];
                $user->nomor_telepon = $userData['nomor_telepon'];
                $user->kewarganegaraan = $userData['kewarganegaraan'];
                $user->status_perkawinan = $userData['status_perkawinan'];
                $user->agama = $userData['agama'];
                $user->pendidikan_tertinggi = $userData['pendidikan'];
                $user->nim = $userData['nim'];
                $user->ipk = $userData['ipk'];
                $user->program_studi = $userData['program_studi'];
                $user->disabilitas = $userData['disabilitas'];
                $user->email_verification = null;
                $user->status = 'active';
                $user->save();

                $createdUsers[] = $user;
            }

            DB::commit();

            return response()->json(['message' => 'Berhasil Mengimport Data User', 'users' => $createdUsers], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal Mengimport Data User'], 500);
        }
    }
}
