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
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Informatika',
            'jurusan' => 'Jurusan Matematika Teknologi dan Informasi',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Matematika',
            'jurusan' => 'Jurusan Matematika Teknologi dan Informasi',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Ilmu Aktuaria',
            'jurusan' => 'Jurusan Matematika Teknologi dan Informasi',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Statistika',
            'jurusan' => 'Jurusan Matematika Teknologi dan Informasi',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Bisnis Digital',
            'jurusan' => 'Jurusan Matematika Teknologi dan Informasi',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Fisika',
            'jurusan' => 'Jurusan Sains, Teknologi Pangan, dan Kemaritiman',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Teknik Perkapalan',
            'jurusan' => 'Jurusan Sains, Teknologi Pangan, dan Kemaritiman',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Teknik Kelautan',
            'jurusan' => 'Jurusan Sains, Teknologi Pangan, dan Kemaritiman',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Teknologi Pangan',
            'jurusan' => 'Jurusan Sains, Teknologi Pangan, dan Kemaritiman',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Teknik Mesin',
            'jurusan' => 'Jurusan Teknologi Industri dan Proses',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Teknik Elektro',
            'jurusan' => 'Jurusan Teknologi Industri dan Proses',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Teknik Kimia',
            'jurusan' => 'Jurusan Teknologi Industri dan Proses',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Teknik Industri',
            'jurusan' => 'Jurusan Teknologi Industri dan Proses',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Rekayasa Keselamatan',
            'jurusan' => 'Jurusan Teknologi Industri dan Proses',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Teknik Logistik',
            'jurusan' => 'Jurusan Teknologi Industri dan Proses',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Teknik Sipil',
            'jurusan' => 'Jurusan Teknik Sipil dan Perencanaan',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Perencanaan Wilayah dan Kota',
            'jurusan' => 'Jurusan Teknik Sipil dan Perencanaan',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Arsitektur',
            'jurusan' => 'Jurusan Teknik Sipil dan Perencanaan',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Desain Komunikasi Visual',
            'jurusan' => 'Jurusan Teknik Sipil dan Perencanaan',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Teknik Lingkungan',
            'jurusan' => 'Jurusan Ilmu Kebumian dan Lingkungan',
        ]);
        DB::Table('prodis')->insert([
            'id' => Str::uuid()->toString(),
            'program_studi' => 'Teknik Material dan Metalurgi',
            'jurusan' => 'Jurusan Ilmu Kebumian dan Lingkungan',
        ]);
    }
}
