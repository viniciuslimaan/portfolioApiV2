<?php

namespace Database\Factories;

use App\Models\Academic;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'semester' => $this->faker->unique()->randomElement(Academic::SEMESTER),
            'image' => 'images/teste.png',
            'description' => $this->faker->randomHtml(1, 1),
        ];
    }
}
