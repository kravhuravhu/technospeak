<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEpisode extends Model
{
    use HasFactory;

    public $timestamps = false; 
    protected $table = 'course_episodes';

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
        'is_free' => 'boolean',
        'created_at' => 'datetime'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // public function getDurationFormattedAttribute()
    // {
    //     $hours = floor($this->duration / 60);
    //     $minutes = $this->duration % 60;
        
    //     if ($hours > 0) {
    //         return sprintf('%dh %02dm', $hours, $minutes);
    //     }
    //     return sprintf('%dm', $minutes);
    // }
    public function getDurationFormattedAttribute()
    {
        $totalSeconds = $this->duration;
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        if ($hours > 0) {
            return "{$hours}h{$minutes}m{$seconds}s";
        } elseif ($minutes > 0) {
            return "{$minutes}m{$seconds}s";
        } else {
            return "0m{$seconds}s";
        }
    }
}