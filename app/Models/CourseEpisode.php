<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEpisode extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'episode_number',
        'duration',
        'video_url'
    ];

    protected $casts = [
        'duration' => 'integer',
        'episode_number' => 'integer',
        'created_at' => 'datetime'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(ClientCourseSubscription::class, 'current_episode_id');
    }

    public function progress()
    {
        return $this->hasMany(EpisodeProgress::class);
    }

    public function getDurationFormattedAttribute()
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        
        if ($hours > 0) {
            return sprintf('%dh %02dm', $hours, $minutes);
        }
        return sprintf('%dm', $minutes);
    }
}