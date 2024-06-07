<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('employers')->insert([
            'id' => Str::uuid()->toString(),
            'username' => 'ddavid',
            'password' => Hash::make('qwerty123'),
            'nama_perusahaan' => 'Infinite',
            'alamat' => 'Balikpapan',
            'provinsi' => 'Kalimantan Timur',
            'kota' => 'Balikpapan',
            'kode_pos' => '76114',
            'website' => 'www.infinite.co.id',
            'bidang_perusahaan' => 'Teknologi',
            'tahun_berdiri' => '2020',
            'kantor_pusat' => 'Balikpapan Selatan',
            'deskripsi_perusahaan' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum',
            'nama_lengkap' => 'David',
            'jabatan' => 'Human Resources',
            'nomor_telepon' => '0812257447874',
            'alamat_email' => 'bdavidliem@gmail.com',
            'logo_perusahaan' => 'logo-copy.png',
            'email_verification' => now(),
            'status' => 'active',
            'created_at' => now(),
        ]);
    }
}
