<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory;

    protected $table = 'course_categories';

    protected $fillable = [
        'name'
    ];

    /**
     * Get all courses in this category
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id');
    }

    /**
     * Get clients who prefer this category
     */
    public function preferredClients()
    {
        return $this->hasMany(Client::class, 'preferred_category_id');
    }

    /**
     * Scope for active categories (with at least one course)
     */
    public function scopeActive($query)
    {
        return $query->whereHas('courses');
    }

    /**
     * Scope for popular categories (with most courses)
     */
    public function scopePopular($query, $limit = 5)
    {
        return $query->withCount('courses')
                   ->orderByDesc('courses_count')
                   ->limit($limit);
    }

    /**
     * Get total duration of all courses in this category
     */
    public function getTotalDurationAttribute()
    {
        return $this->courses->sum('total_duration');
    }

    /**
     * Get formatted total duration
     */
    public function getFormattedTotalDurationAttribute()
    {
        $totalMinutes = $this->total_duration;
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        if ($hours > 0) {
            return sprintf('%dh %02dm', $hours, $minutes);
        }
        return sprintf('%dm', $minutes);
    }

    /**
     * Get count of active courses
     */
    public function getActiveCoursesCountAttribute()
    {
        return $this->courses()->count();
    }

    /**
     * Get thumbnail for the category (uses first course's thumbnail)
     */
    public function getThumbnailAttribute()
    {
        $course = $this->courses()->first();
        return $course ? $course->thumbnail : null;
    }

    /**
     * Get thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/'.$this->thumbnail) : asset('images/default-category.png');
    }
}