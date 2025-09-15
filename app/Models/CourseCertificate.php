<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCertificate extends Model
{
    protected $table = 'course_certificates';

    protected $fillable = [
        'course_id',
        'subscription_id',
        'client_id',
        'certificate_id',
        'certificate_url',
        'issued_at',
        'expires_at',
    ];

    public $timestamps = false; 
}
