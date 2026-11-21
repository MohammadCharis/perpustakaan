<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    public function definition(): array
    {
        return ['member_code' => 'AGT-'.fake()->unique()->numerify('####'), 'name' => fake()->name(), 'phone' => fake()->phoneNumber(), 'address' => fake()->address(), 'is_active' => true];
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => ['is_active' => false]);
    }
}
