<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Traits\UUID;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('contents')->insert([
            'id' => '0f9d7b57-a1fa-4cc0-9aef-3dd5eb030c99',
            'category' => 'Carousel',
            'status' => True,
            'title' => 'default1',
            'image' => '0f9d7b57-a1fa-4cc0-9aef-3dd5eb030c99.png'
        ]);
        DB::Table('contents')->insert([
            'id' => 'f625b5c1-7cff-4479-aae4-c94e012adfcc',
            'category' => 'Carousel',
            'status' => True,
            'title' => 'default2',
            'image' => 'f625b5c1-7cff-4479-aae4-c94e012adfcc.png'
        ]);
        DB::Table('contents')->insert([
            'id' => '59a477ff-f39a-4714-b849-eb1d57260f7e',
            'category' => 'Carousel',
            'status' => True,
            'title' => 'default3',
            'image' => '59a477ff-f39a-4714-b849-eb1d57260f7e.png'
        ]);
    }
}
