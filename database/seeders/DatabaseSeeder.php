<?php

namespace Database\Seeders;

use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create(['name' => 'Administrator', 'email' => 'admin@perpus.test', 'password' => Hash::make('password'), 'role' => 'admin']);
        $petugas = User::factory()->create(['name' => 'Petugas', 'email' => 'petugas@perpus.test', 'password' => Hash::make('password'), 'role' => 'petugas']);
        $categories = collect(['Fiksi', 'Teknologi', 'Sejarah', 'Sains', 'Referensi'])->map(fn (string $name) => Category::create(['name' => $name]));
        $books = Book::factory(25)->recycle($categories)->create();
        $members = Member::factory(8)->create()->merge(Member::factory(2)->inactive()->create());
        $members->values()->each(function (Member $member, int $index): void {
            $member->update(['member_code' => 'AGT-'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT)]);
        });
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
