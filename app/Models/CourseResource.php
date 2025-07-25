<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseResource extends Model
{
    protected $table = 'course_resources';

    protected $fillable = [
        'course_id',
        'category_id',
        'resource_type_id',
        'title',
        'description',
        'file_url',
        'file_type',
        'file_size',
        'thumbnail_url',
    ];

    public $timestamps = true;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function resourceType()
    {
        return $this->belongsTo(ResourceType::class, 'resource_type_id');
    }
}
