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
        'price',
        'thumbnail',
        'software_app_icon',
        'level',
        'total_duration',
        'noEpisodes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
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

    public function getFormattedPriceAttribute()
    {
        return $this->plan_type === 'paid' ? '$' . number_format($this->price, 2) : 'Free';
    }

    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->total_duration / 60);
        $minutes = $this->total_duration % 60;
        
        if ($hours > 0) {
            return sprintf('%dh %02dm', $hours, $minutes);
        }
        return sprintf('%dm', $minutes);
    }

    // public function scopeActive($query)
    // {
    //     return $query->where('is_active', true);
    // }

    public function scopePaid($query)
    {
        return $query->where('plan_type', 'paid');
    }

    public function scopeFree($query)
    {
        return $query->where('plan_type', 'free');
    }
}