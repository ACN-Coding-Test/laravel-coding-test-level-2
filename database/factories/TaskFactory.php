<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition()
    { 
        return [
            'title'         => $this->faker->unique()->name(),
            'description'   => $this->faker->sentence(),
            'status'        => 'PRODUCT_OWNER',
        ];
    }
}
