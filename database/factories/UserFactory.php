<?php

namespace Database\Factories;

use App\Models\Pendidikan;
use App\Models\Sertifikasi;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pengalaman;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $gender = $this->faker->randomElement(['male', 'female']);
        $status = $this->faker->randomElement(['Belum Kawin', 'Menikah']);
        $uuid = Str::uuid();
        $randomTimestamp = mt_rand(strtotime('-6 months'), time());
        $randomDate = date('Y-m-d H:i:s', $randomTimestamp);


        return [
            'id' => $uuid,
            'username' => $this->faker->userName,
            'password' => Hash::make('qwerty123'),
            'profile' => 'default-profile.png',
            'resume' => 'default-resume.pdf',
            'nama_lengkap' => $this->faker->name(),
            'alamat_email' => $this->faker->unique()->safeEmail,
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date,
            'jenis_kelamin' => $gender,
            'alamat' => $this->faker->address,
            'kota' => $this->faker->city,
            'kode_pos' => $this->faker->postcode,
            'nomor_telepon' => $this->faker->phoneNumber,
            'kewarganegaraan' => 'WNI',
            'status_perkawinan' => $status,
            'agama' => $this->faker->randomElement(['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha']),
            'pendidikan_tertinggi' => $this->faker->randomElement(['SMP', 'SMA', 'D3', 'S1', 'S2']),
            'nim' => $this->faker->numerify('########'),
            'program_studi' => $this->faker->randomElement(['Sistem Informasi', 'Informatika', 'Matematika', 'Ilmu Aktuaria']),
            'email_verification' => $randomDate,
            'created_at' => $randomDate,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $this->associatePengalaman($user);
            $this->associatePendidikan($user);
            $this->associateSertifikat($user);
            $this->associateAppointment($user);
        });
    }

    private function associatePengalaman(User $user)
    {
        $filepath = base_path('database/factories/pengalaman.json');
        $pengalamanData = json_decode(file_get_contents($filepath), true);
        $randomData = $this->getRandomSubset($pengalamanData['pengalaman']);
        $jenis_pekerjaan = $this->faker->randomElement(['Full Time', 'Part Time', 'Freelance', 'Contract', 'Internship', 'Apprenticeship']);

        foreach ($randomData as $data) {
            $data['user_id'] = $user->id;
            $data['jenis_pekerjaan'] = $jenis_pekerjaan;
            Pengalaman::create($data);
        }
    }

    private function associatePendidikan(User $user)
    {
        $filepath = base_path('database/factories/pendidikan.json');
        $pendidikanData = json_decode(file_get_contents($filepath), true);
        $randomData = $this->getRandomSubset($pendidikanData['pendidikan']);
        $tingkat_pendidikan = $this->faker->randomElement(['Sekolah Menengah Atas', 'Diploma-1', 'Diploma-2', 'Diploma-3', 'Strata-1', 'Strata-2', 'Strata-3']);

        foreach ($randomData as $data) {
            $data['user_id'] = $user->id;
            $data['tingkat_pendidikan'] = $tingkat_pendidikan;
            Pendidikan::create($data);
        }
    }

    private function associateSertifikat(User $user)
    {
        $filepath = base_path('database/factories/sertifikat.json');
        $sertifikatData = json_decode(file_get_contents($filepath), true);
        $randomData = $this->getRandomSubset($sertifikatData['sertifikat']);

        foreach ($randomData as $data) {
            $data['user_id'] = $user->id;
            Sertifikasi::create($data);
        }
    }

    private function associateAppointment(User $user)
    {
        $filepath = base_path('database/factories/appointment.json');
        $appointmentData = json_decode(file_get_contents($filepath), true);
        $randomData = $this->getRandomSubset($appointmentData['appointment']);
        $startDate = strtotime('-6 months');
        $endDate = time();
        $randomTimestamp = rand($startDate, $endDate);
        $randomDate = date('Y-m-d H:i:s', $randomTimestamp);

        foreach ($randomData as $data) {
            $data['user_id'] = $user->id;
            $data['date_time'] = $randomDate;
            $data['jenis_konseling'] = $this->faker->randomElement(['individu', 'kelompok']);
            $data['tempat_konseling'] = $this->faker->randomElement(['online', 'offline']);
            $data['google_meet'] = "test google_meet";
            $data['status'] = $this->faker->randomElement(['finished', 'declined', 'reschedule', 'accepted', 'pending']);
            $data['feedback'] = "Appointment Feedback 123";
            $data['created_at'] = $randomDate;
            Appointment::create($data);
        }
    }

    private function getRandomSubset($data)
    {
        $minCount = 1;
        $randomCount = rand($minCount, count($data));

        return array_slice($data, 0, $randomCount);
    }
}
