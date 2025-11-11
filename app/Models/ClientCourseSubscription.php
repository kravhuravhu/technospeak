<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCourseSubscription extends Model
{
    use HasFactory;

    protected $table = 'client_course_subscriptions';

    protected $fillable = [
        'client_id',
        'course_id',
        'course_uuid',
        'payment_status',
        'progress',
        'current_episode_id',
        'started_at',
        'last_accessed_at',
        'completed',
        'completed_at'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'last_accessed_at' => 'datetime',
        'completed_at' => 'datetime',
        'completed' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function currentEpisode()
    {
        return $this->belongsTo(CourseEpisode::class, 'current_episode_id');
    }

        // public function episodeProgress()
    // {
    //     return $this->hasMany(CourseEpisodeProgress::class, 'subscription_id');
    // }

    public function certificate()
    {
        return $this->hasOne(CourseCertificate::class, 'subscription_id');
    }

    public function markAsCompleted()
    {
        $this->update([
            'completed' => true,
            'completed_at' => now(),
            'progress' => 100
        ]);
    }

    // Add a method to get completed episode IDs (if you track this elsewhere)
    public function getCompletedEpisodeIds()
    {
        // Since you don't have course_episode_progress table,
        // you might need to implement this differently based on your actual progress tracking
        return collect(); // Return empty collection for now
    }
}