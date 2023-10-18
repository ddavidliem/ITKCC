<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Sistem Informasi',
            'jurusan' => 'Jurusan Matematika Teknologi dan Informasi',
        ]);
    }
}
