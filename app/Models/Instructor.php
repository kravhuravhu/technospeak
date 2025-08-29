<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Instructor extends Authenticatable

{
    protected $fillable = [
        'name', 
        'surname', 
        'job_title', 
        'email', 
        'password',
        'bio', 
        'thumbnail',
        'features', 
        'created_at', 
        'updated_at'
    ];

    protected $casts = [
        'features' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}