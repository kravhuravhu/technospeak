<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalGuideRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'topic',
        'description',
        'availability',
        'preferred_method',
        'hours_requested',
        'status',
        'scheduled_time',
        'instructor_id',
        'meeting_link',
        'payment_id'
    ];

    protected $casts = [
        'scheduled_time' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}