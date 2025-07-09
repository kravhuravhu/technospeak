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
        return $this->total_duration;
    }

    public function scopePaid($query)
    {
        return $query->where('plan_type', 'paid');
    }

    public function scopeFree($query)
    {
        return $query->where('plan_type', 'free');
    }
}