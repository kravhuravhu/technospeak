<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = [
        'name', 
        'surname', 
        'job_title', 
        'email', 
        'bio', 
        'features', 
        'created_at', 
        'updated_at'
    ];

    protected $casts = [
        'features' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function assignedIssues()
    {
        return $this->hasMany(Issue::class, 'assigned_to');
    }

    public function assignments()
    {
        return $this->hasMany(IssueAssignment::class);
    }
}