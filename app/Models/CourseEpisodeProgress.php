<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEpisodeProgress extends Model
{
    use HasFactory;

    protected $table = 'course_episode_progress'; // Adjust table name if different

    protected $fillable = [
        'subscription_id',
        'episode_id',
        'watched_seconds',
        'progress_percent',
        'is_completed',
        'last_played_at',
        'completed_at'
    ];

    protected $casts = [
        'last_played_at' => 'datetime',
        'completed_at' => 'datetime',
        'is_completed' => 'boolean',
    ];

    public function subscription()
    {
        return $this->belongsTo(ClientCourseSubscription::class, 'subscription_id');
    }

    public function episode()
    {
        return $this->belongsTo(CourseEpisode::class, 'episode_id');
    }
}