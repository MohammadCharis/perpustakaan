<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Enums\LoanStatus;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create(['name' => 'Administrator', 'email' => 'admin@perpus.test', 'password' => Hash::make('password'), 'role' => 'admin']);
        $petugas = User::factory()->create(['name' => 'Petugas', 'email' => 'petugas@perpus.test', 'password' => Hash::make('password'), 'role' => 'petugas']);
        $categories = collect(['Fiksi', 'Teknologi', 'Sejarah', 'Sains', 'Referensi'])->map(fn (string $name) => Category::create(['name' => $name]));
        $books = Book::factory(25)->recycle($categories)->create();
        $members = Member::factory(10)->create();
        $loans = collect();
        foreach ($members->take(5) as $member) {
            $loans->push(Loan::create(['book_id' => $books->random()->id, 'member_id' => $member->id, 'user_id' => $petugas->id, 'loan_date' => now()->subDays(12), 'due_date' => now()->subDays(5), 'status' => LoanStatus::Terlambat]));
        }
        foreach ($members->skip(5) as $member) {
            $loans->push(Loan::create(['book_id' => $books->random()->id, 'member_id' => $member->id, 'user_id' => $admin->id, 'loan_date' => now(), 'due_date' => now()->addDays(7), 'status' => LoanStatus::Dipinjam]));
        }
        foreach ($loans->take(3) as $loan) {
            Fine::create(['loan_id' => $loan->id, 'days_late' => 5, 'amount' => 5000, 'status' => 'belum_dibayar']);
        }
    }
}
