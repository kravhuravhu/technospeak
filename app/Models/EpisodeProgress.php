<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpisodeProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'episode_id',
        'progress_percent',
        'is_completed',
        'last_played_at',
        'completed_at'
    ];

    protected $casts = [
        'progress_percent' => 'integer',
        'is_completed' => 'boolean',
        'last_played_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    public function subscription()
    {
        return $this->belongsTo(ClientCourseSubscription::class, 'subscription_id');
    }

    public function episode()
    {
        return $this->belongsTo(CourseEpisode::class);
    }

    public function updateProgress($percent, $isCompleted = false)
    {
        $this->update([
            'progress_percent' => $percent,
            'is_completed' => $isCompleted,
            'last_played_at' => now(),
            'completed_at' => $isCompleted ? now() : null
        ]);
    }
}