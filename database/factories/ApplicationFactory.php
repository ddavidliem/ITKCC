<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Loker;
use App\Models\Application;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    protected $model = Application::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user_ids = User::pluck('id')->toArray();
        $loker_ids = Loker::pluck('id')->toArray();
        $user_id = $this->faker->unique()->randomElement($user_ids);
        $loker_id = $this->faker->randomElement($loker_ids);
        $uuid = Str::uuid();

        return [
            'id' => $uuid,
            'user_id' => $user_id,
            'loker_id' => $loker_id,
            'nama_lengkap' => User::find($user_id)->nama_lengkap,
            'alamat_email' => User::find($user_id)->alamat_email,
            'tempat_lahir' => User::find($user_id)->tempat_lahir,
            'tanggal_lahir' => User::find($user_id)->tanggal_lahir,
            'jenis_kelamin' => User::find($user_id)->jenis_kelamin,
            'alamat' => User::find($user_id)->alamat,
            'kota' => User::find($user_id)->kota,
            'kode_pos' => User::find($user_id)->kode_pos,
            'nomor_telepon' => User::find($user_id)->nomor_telepon,
            'kewarganegaraan' => User::find($user_id)->kewarganegaraan,
            'status_perkawinan' => User::find($user_id)->status_perkawinan,
            'agama' => User::find($user_id)->agama,
            'pendidikan_tertinggi' => User::find($user_id)->pendidikan_tertinggi,
            'nim' => User::find($user_id)->nim,
            'ipk' => User::find($user_id)->ipk,
            'program_studi' => User::find($user_id)->program_studi,
            'disabilitas' => User::find($user_id)->disabilitas,
            'status' => $this->faker->randomElement(['accepted', 'declined']),
            'feedback' => $this->faker->paragraph(),
        ];
    }
}
