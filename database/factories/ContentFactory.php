<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'category' => "Berita",
            'status' => $this->faker->boolean(),
            'image' => 'default-news.jpg',
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(150),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
