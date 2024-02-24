<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Approval;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Approval>
 */
class ApprovalFactory extends Factory
{
    protected $model = Approval::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $uuid = Str::uuid();
        $randomTimestamp = mt_rand(strtotime('-6 months'), time());
        $randomDate = date('Y-m-d H:i:s', $randomTimestamp);
        return [
            "id" => $uuid,
            "username" => $this->faker->userName,
            "password" => Hash::make('qwerty123'),
            "nama_perusahaan" => $this->faker->company(),
            "alamat" => $this->faker->address(),
            "provinsi" => $this->faker->state(),
            "kota" => $this->faker->city(),
            "kode_pos" => $this->faker->postcode(),
            "website" => $this->faker->url(),
            "nama_lengkap" => $this->faker->name(),
            "jabatan" => $this->faker->jobTitle(),
            "nomor_telepon" => $this->faker->phoneNumber(),
            "alamat_email" => $this->faker->email(),
            "formulir" => "default-formulir.pdf",
            "status" => "pending",
            "created_at" => $randomDate,
        ];
    }
}
