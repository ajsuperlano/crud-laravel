<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ListaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}