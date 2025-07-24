<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseResource extends Model
{
    protected $table = 'course_resources';

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'file_url',
        'file_type',
        'file_size',
    ];

    public $timestamps = true;
}
