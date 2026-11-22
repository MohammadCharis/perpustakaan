<?php

namespace App;

use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanService
{
    public function loan(Book $book, Member $member, int $userId): Loan
    {
        return DB::transaction(function () use ($book, $member, $userId): Loan {
            $member->loadCount(['loans as active_loans_count' => fn ($query) => $query->whereNull('returned_at')]);
            if (! $member->is_active) {
                throw ValidationException::withMessages(['member_id' => 'Anggota tidak aktif.']);
            }
            if ($member->active_loans_count >= config('library.max_active_loans')) {
                throw ValidationException::withMessages(['member_id' => 'Batas peminjaman tercapai.']);
            }
            if ($member->loans()->whereHas('fine', fn ($query) => $query->where('status', 'belum_dibayar'))->exists()) {
                throw ValidationException::withMessages(['member_id' => 'Anggota memiliki denda belum dibayar.']);
            }
            $lockedBook = Book::query()->lockForUpdate()->findOrFail($book->id);
            if ($lockedBook->stock < 1) {
                throw ValidationException::withMessages(['book_id' => 'Buku tidak tersedia.']);
            }
            $lockedBook->decrement('stock');

            return Loan::create(['book_id' => $lockedBook->id, 'member_id' => $member->id, 'user_id' => $userId, 'loan_date' => now(), 'due_date' => now()->addDays(config('library.loan_days')), 'status' => LoanStatus::Dipinjam]);
        });
    }

    public function return(Loan $loan): Loan
    {
        return DB::transaction(function () use ($loan): Loan {
            if ($loan->returned_at) {
                return $loan;
            } $daysLate = max(0, $loan->due_date->diffInDays(now(), false));
            $fine = $daysLate * config('library.fine_per_day');
            $loan->update(['returned_at' => now(), 'status' => LoanStatus::Dikembalikan]);
            $loan->book->increment('stock');
            if ($fine > 0) {
                Fine::updateOrCreate(['loan_id' => $loan->id], ['days_late' => $daysLate, 'amount' => $fine, 'status' => 'belum_dibayar']);
            }

            return $loan->fresh();
        });
    }

    public function markOverdue(): int
    {
        $overdueLoans = Loan::query()
            ->whereNull('returned_at')
            ->where('due_date', '<', now()->startOfDay())
            ->get();

        foreach ($overdueLoans as $loan) {
            $daysLate = max(1, $loan->due_date->diffInDays(now()->startOfDay()));
            $loan->update(['status' => LoanStatus::Terlambat]);
            Fine::updateOrCreate(
                ['loan_id' => $loan->id],
                ['days_late' => $daysLate, 'amount' => $daysLate * config('library.fine_per_day'), 'status' => 'belum_dibayar', 'paid_at' => null],
            );
        }

        return $overdueLoans->count();
    }
}
