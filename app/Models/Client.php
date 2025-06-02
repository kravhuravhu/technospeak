<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Client extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    protected $connection = 'technospeak_db';
    protected $table = 'clients';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id', 'name', 'surname', 'email', 'password',
        'subscription_id', 'preferred_category_id',
        'registered_date', 'registered_time',
        'remember_token', 'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
