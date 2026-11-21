<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Member extends Model { use HasFactory; protected $fillable = ['member_code', 'name', 'email', 'phone', 'address', 'joined_at', 'active']; protected function casts(): array { return ['joined_at' => 'date', 'active' => 'boolean']; } public function loans() { return $this->hasMany(Loan::class); } }
