<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceType extends Model
{
    protected $table = 'resource_types';

    protected $fillable = [
        'name',
    ];

    public $timestamps = true;

    // Related resources
    public function resources()
    {
        return $this->hasMany(CourseResource::class, 'resource_type_id');
    }
}
