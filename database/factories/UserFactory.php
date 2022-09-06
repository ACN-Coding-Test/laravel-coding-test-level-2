<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'password' => '$2y$10$QY1v7OuVtqwOc7SE88wqbej7K35KYfyltM9Ag90LnVpL3lbcFaIrC',
            'role'=>$this->faker->randomElement(['admin','product_owner','team_member']),
        ];
    }
}
