<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    protected $fillable = ['loan_id', 'days_late', 'amount', 'status', 'paid_at'];

    protected function casts(): array
    {
        return ['paid_at' => 'date'];
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
