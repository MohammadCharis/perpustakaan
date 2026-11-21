<?php
namespace Database\Factories;
use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;
class FineFactory extends Factory { public function definition(): array { return ['loan_id' => Loan::factory(), 'amount' => fake()->numberBetween(1000, 50000), 'status' => 'unpaid']; } }
