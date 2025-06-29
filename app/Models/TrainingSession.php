<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type_id',
        'title',
        'description',
        'instructor_id',
        'scheduled_at',
        'duration_minutes',
        'price',
        'max_participants',
        'created_at'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'duration_minutes' => 'integer',
        'price' => 'decimal:2',
        'max_participants' => 'integer',
        'created_at' => 'datetime'
    ];

    public function type()
    {
        return $this->belongsTo(TrainingType::class, 'type_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function registrations()
    {
        return $this->hasMany(TrainingRegistration::class, 'session_id');
    }

    public function getAvailableSpotsAttribute()
    {
        return $this->max_participants - $this->registrations()->count();
    }

    public function isFull()
    {
        return $this->max_participants && 
               $this->registrations()->count() >= $this->max_participants;
    }

    public function scopeUpcoming(Builder $query): void
    {
        $query->where('scheduled_at', '>', now());
    }
}