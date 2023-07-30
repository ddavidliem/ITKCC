<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Traits\UUID;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    use UUID;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'id' => Str::uuid()->toString(),
            'username' => 'admin',
            'password' => Hash::make('qwerty123'),
            'alamat_email' => 'ddavidliem@gmail.com'
        ]);
    }
}
