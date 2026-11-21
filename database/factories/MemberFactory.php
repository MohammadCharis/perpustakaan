<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    public function definition(): array
    {
        return ['member_code' => 'M'.fake()->unique()->numerify('#####'), 'name' => fake()->name(), 'phone' => fake()->phoneNumber(), 'address' => fake()->address(), 'is_active' => true];
    }
}
