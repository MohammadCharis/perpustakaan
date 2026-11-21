<?php
namespace App;
use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class LoanService {
    public function loan(Book $book, Member $member): Loan { return DB::transaction(function () use ($book, $member): Loan { if (! $member->active) { throw ValidationException::withMessages(['member_id' => 'Member is inactive.']); } if ($book->stock < 1) { throw ValidationException::withMessages(['book_id' => 'Book is unavailable.']); } $book->decrement('stock'); return Loan::create(['book_id' => $book->id, 'member_id' => $member->id, 'loaned_at' => now(), 'due_at' => now()->addDays(7), 'status' => LoanStatus::Borrowed]); }); }
    public function return(Loan $loan): Loan { return DB::transaction(function () use ($loan): Loan { if ($loan->returned_at) { return $loan; } $daysLate = max(0, $loan->due_at->diffInDays(now(), false)); $fine = $daysLate * 1000; $loan->update(['returned_at' => now(), 'status' => LoanStatus::Returned, 'fine_amount' => $fine]); $loan->book->increment('stock'); if ($fine > 0) { Fine::updateOrCreate(['loan_id' => $loan->id], ['amount' => $fine, 'status' => 'unpaid']); } return $loan->fresh(); }); }
    public function markOverdue(): int { return Loan::whereNull('returned_at')->where('due_at', '<', now()->toDateString())->update(['status' => LoanStatus::Overdue]); }
}
