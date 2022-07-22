<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_user_id',
        'recipient_email',
        'status',
    ];

    public function referrer() {
        return $this->belongsTo(User::class, 'referrer_user_id', 'id');
    }
}
