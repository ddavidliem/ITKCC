<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employer;
use App\Models\Loker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employer>
 */
class EmployerFactory extends Factory
{

    protected $model = Employer::class;
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
            "logo_perusahaan" => "default-logo.png",
            "bidang_perusahaan" => $this->faker->word(),
            "tahun_berdiri" => $this->faker->year(),
            "kantor_pusat" => $this->faker->address(),
            "deskripsi_perusahaan" => $this->faker->paragraph(),
            "nama_lengkap" => $this->faker->name(),
            "jabatan" => $this->faker->jobTitle(),
            "nomor_telepon" => $this->faker->phoneNumber(),
            "alamat_email" => $this->faker->email(),
            "email_verification" =>  $this->faker->randomElement([now(), null]),
            "google_id" => $this->faker->uuid(),
            "created_at" => $randomDate,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Employer $employer) {
            $this->associateLoker($employer);
        });
    }

    private function associateLoker(Employer $employer)
    {
        $loker = [];

        $entryCount = $this->faker->numberBetween(1, 5);
        $startDate = strtotime('+1 months');
        $endDate = time();
        $randomTimestamp = rand($startDate, $endDate);
        $randomDate = date('Y-m-d H:i:s', $randomTimestamp);

        for ($i = 0; $i < $entryCount; $i++) {
            $loker[] = [
                'nama_pekerjaan' => $this->faker->jobTitle(),
                'jenis_pekerjaan' => $this->faker->randomElement(['Full Time', 'Part Time', 'Contract', 'Volunteer', 'Internship', 'Other']),
                'tipe_pekerjaan' => $this->faker->randomElement(['WFO', 'WFH', 'Hybrid']),
                'deskripsi_pekerjaan' => $this->faker->paragraph(),
                'lokasi_pekerjaan' => $this->faker->address(),
                'poster' => 'default-poster.png',
                'status' => $this->faker->randomElement(['Open', 'Close']),
                'deadline' => $randomDate,
                'employer_id' => $employer->id,
                'created_at' => now(),
            ];
        }
        foreach ($loker as $data) {
            Loker::create($data);
        }
    }
}
