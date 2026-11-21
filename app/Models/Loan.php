<?php

namespace App\Models;

use App\Enums\LoanStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'member_id', 'user_id', 'loan_date', 'due_date', 'returned_at', 'status'];

    protected function casts(): array
    {
        return ['loan_date' => 'date', 'due_date' => 'date', 'returned_at' => 'date', 'status' => LoanStatus::class];
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function fine(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Fine::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
