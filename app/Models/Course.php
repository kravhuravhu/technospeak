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
        'description',
        'instructor',
        'plan_type',
        'price',
        'thumbnail',
        'level',
        'total_duration'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total_duration' => 'integer',
        'created_at' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function episodes()
    {
        return $this->hasMany(CourseEpisode::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(ClientCourseSubscription::class);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/'.$this->thumbnail) : asset('images/default-course.png');
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