<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Database\Factories\UserFactory;
use Database\Factories\EmployerFactory;
use Database\Factories\ContentFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(EmployerSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ContentSeeder::class);
        $this->call(TopicSeeder::class);
        $this->call(ProdiSeeder::class);
        \App\Models\User::factory(100)->create();
        \App\Models\Employer::factory(30)->create();
        \App\Models\Application::factory(100)->create();
        \App\Models\Content::factory(20)->create();
        \App\Models\Approval::factory(20)->create();
    }
}
