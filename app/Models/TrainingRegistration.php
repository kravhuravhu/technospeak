<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'session_id',
        'payment_status',
        'attended'
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'attended' => 'boolean'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function session()
    {
        return $this->belongsTo(TrainingSession::class, 'session_id');
    }

    public function markAsAttended()
    {
        $this->update([
            'attended' => true
        ]);
    }
}