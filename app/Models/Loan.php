<?php
namespace App\Models;
use App\Enums\LoanStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Loan extends Model { use HasFactory; protected $fillable = ['book_id', 'member_id', 'loaned_at', 'due_at', 'returned_at', 'status', 'fine_amount']; protected function casts(): array { return ['loaned_at' => 'date', 'due_at' => 'date', 'returned_at' => 'date', 'status' => LoanStatus::class]; } public function book() { return $this->belongsTo(Book::class); } public function member() { return $this->belongsTo(Member::class); } public function fine() { return $this->hasOne(Fine::class); } }
