<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'reg_num' => fake()->bothify('?###??'),
            'model' => fake()->randomElement(['KIA', 'Lada', 'Renault', 'Honda']),
            'car_user_id' => null,
        ];
    }
}
