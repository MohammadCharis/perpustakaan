<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    public function definition(): array
    {
        $loanedAt = now()->subDays(fake()->numberBetween(0, 10));

        return ['book_id' => Book::factory(), 'member_id' => Member::factory(), 'user_id' => User::factory(), 'loan_date' => $loanedAt, 'due_date' => $loanedAt->copy()->addDays(7), 'status' => 'dipinjam'];
    }
}
