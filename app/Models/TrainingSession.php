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
        'max_participants'
    ];

    protected $casts = [
        'scheduled_for' => 'datetime',
        'from_time' => 'datetime:H:i',
        'to_time' => 'datetime:H:i',
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

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function getPriceForUser(Client $client): float
    {
        return $this->type->getPriceForUserType($client->userType);
    }

    public function getAvailableSpotsAttribute()
    {
        return $this->max_participants ? 
               $this->max_participants - $this->registrations()->count() : 
               null;
    }

    public function isFull(): bool
    {
        if ($this->type->is_group_session) {
            return $this->registrations()->count() >= $this->max_participants;
        }
        return $this->registrations()->exists();
    }

    public function scopeUpcoming(Builder $query): void
    {
        $query->where('scheduled_for', '>', now());
    }

    // convert seconds to readable
    public function getFormattedDurationAttribute()
    {
        $totalSeconds = $this->duration_seconds;
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        if ($hours > 0) {
            return "{$hours}h{$minutes}m";
        } elseif ($minutes > 0) {
            return "{$minutes}m{$seconds}s";
        } else {
            return "0m{$seconds}s";
        }
    }

    public static function getUpcomingSessions()
    {
        $now = now();
        
        $future = self::with('type')
            ->where('scheduled_for', '>', $now)
            ->orderBy('scheduled_for')
            ->limit(4)
            ->get();

        if ($future->count() < 4) {
            $remaining = 4 - $future->count();
            $past = self::with('type')
                ->where('scheduled_for', '<=', $now)
                ->orderByDesc('scheduled_for')
                ->limit($remaining)
                ->get();
            return $future->concat($past);
        }

        return $future;
    }
}