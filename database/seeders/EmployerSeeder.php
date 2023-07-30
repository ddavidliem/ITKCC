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
            'nama_perusahaan' => 'ngt',
            'alamat' => 'Balikpapan',
            'provinsi' => 'Kalimantan Timur',
            'kota' => 'Balikpapan',
            'kode_pos' => '76114',
            'website' => 'ngt.co',
            'nama_lengkap' => 'David',
            'jabatan' => 'Human Resources',
            'nomor_telepon' => '0812257447874',
            'alamat_email' => 'ddavid@gmail.com',
        ]);
    }
}
