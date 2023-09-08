<?php

namespace Database\Factories;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortfolioFactory extends Factory
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
            'type' => $this->faker->randomElement(Portfolio::TYPE),
            'image' => $this->faker->imageUrl(640, 480, 'teste', true),
            'deploy' => $this->faker->url(),
            'github' => $this->faker->url(),
            'figma' => $this->faker->url(),
        ];
    }
}
