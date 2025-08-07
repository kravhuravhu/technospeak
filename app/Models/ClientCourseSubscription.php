<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCourseSubscription extends Model
{
    use HasFactory;

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
        'subscribed_at' => 'datetime',
        'completed' => 'boolean',
        'completed_at' => 'datetime'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function currentEpisode()
    {
        return $this->belongsTo(CourseEpisode::class, 'current_episode_id');
    }

    public function episodeProgress()
    {
        return $this->hasMany(EpisodeProgress::class, 'subscription_id');
    }

    public function certificate()
    {
        return $this->hasOne(CourseCertificate::class, 'subscription_id');
    }

    public function resources()
    {
        return $this->hasMany(CourseResource::class, 'course_id');
    }

    public function markAsCompleted()
    {
        $this->update([
            'completed' => true,
            'completed_at' => now()
        ]);
    }
}