<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type_id',
        'description',
        'from_time',
        'to_time',
        'duration_seconds',
        'category_id',
        'instructor_id',
        'scheduled_for',
        'max_participants',
    ];

    protected $casts = [
        'scheduled_for' => 'datetime',
        'max_participants' => 'integer',
        'created_at' => 'datetime'
    ];

    public function type()
    {
        return $this->belongsTo(TrainingType::class, 'type_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function registrations()
    {
        return $this->hasMany(TrainingRegistration::class, 'session_id');
    }

    public function getAvailableSpotsAttribute()
    {
        return $this->max_participants ? 
               $this->max_participants - $this->registrations()->count() : 
               null;
    }

    public function isFull()
    {
        return $this->max_participants && 
               $this->registrations()->count() >= $this->max_participants;
    }

    public function scopeUpcoming(Builder $query): void
    {
        $query->where('scheduled_for', '>', now());
    }

    // convert seconds to readable
    public function getDurationAttribute()
    {
        $seconds = $this->duration_seconds;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        $parts = [];
        if ($hours > 0) $parts[] = $hours . 'h';
        if ($minutes > 0) $parts[] = $minutes . 'm';
        if ($seconds > 0 || empty($parts)) $parts[] = $seconds . 's';

        return implode(' ', $parts);
    }
}