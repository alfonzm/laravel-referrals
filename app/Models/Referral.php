<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
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

    public static function boot() {
        parent::boot();

        self::creating(function ($model) {
            $model->code = (string) Str::uuid();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function referrer() {
        return $this->belongsTo(User::class, 'referrer_user_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor methods
    |--------------------------------------------------------------------------
    */

    public function getInviteLinkAttribute() {
        return route('registerReferral', ['code' => $this->code]);
    }
}
