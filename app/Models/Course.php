<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'instructor_id',
        'description',
        'catch_phrase',
        'plan_type',
        'thumbnail',
        'software_app_icon',
        'level',
        'total_duration',
        'noEpisodes',
    ];

    protected $casts = [
        'total_duration' => 'integer',
        'noEpisodes' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(CourseCategory::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function episodes()
    {
        return $this->hasMany(CourseEpisode::class);
    }

    public function getFormattedDurationAttribute()
    {
        $totalSeconds = $this->total_duration;
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

    public function getTitleAttribute($value)
    {
        return ucwords($value);
    }

    public function getCatchPhraseAttribute($value)
    {
        return ucfirst($value);
    }

    public function getDescriptionAttribute($value)
    {
        return ucfirst($value);
    }
    
    public function getLevelAttribute($value) 
    {
        return ucwords($value);
    }

    public function scopePaid($query)
    {
        return $query->where('plan_type', 'paid');
    }

    public function scopeFree($query)
    {
        return $query->where('plan_type', 'free');
    }

    public function comments()
    {
        return $this->hasMany(CourseComment::class)->whereNull('parent_id');
    }

    public function ratings()
    {
        return $this->hasMany(CourseRating::class);
    }

    public function resources()
{
    return $this->hasMany(CourseResource::class, 'course_id');
}

}
