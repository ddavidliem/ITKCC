<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => '669e177b-a74c-42ef-9469-bd5f223ceeaa',
            'username' => 'ddavid',
            'password' => Hash::make('qwerty123'),
            'profile' => '669e177b-a74c-42ef-9469-bd5f223ceeaa.png',
            'resume' => '669e177b-a74c-42ef-9469-bd5f223ceeaa.pdf',
            'nama_lengkap' => 'David Liem',
            'alamat_email' => 'ddavidliem@gmail.com',
            'tempat_lahir' => 'Balikpapan',
            'tanggal_lahir' => Date::make('2023-04-18'),
            'jenis_kelamin' => 'pria',
            'alamat' => 'Balikpapan',
            'kota' => 'Balikpapan',
            'kode_pos' => '76115',
            'nomor_telepon' => '081258370875',
            'kewarganegaraan' => 'WNI',
            'status_perkawinan' => 'Belum Kawin',
            'agama' => 'Kristen Protestan',
            'pendidikan_tertinggi' => 'SMA',
            'nim' => '10181014',
            'program_studi' => 'Sistem Informasi',
            'email_verification' => now(),
            'created_at' => now(),
        ]);
    }
}
