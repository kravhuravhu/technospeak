<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Cache;

class Client extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'surname',
        'email',
        'password',
        'preferred_category_id',
        'subscription_type',
        'subscription_expiry',
        'registered_date',
        'registered_time',
        'remember_token',
        'email_verified_at',
        'userType'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'subscription_expiry' => 'date',
        'registered_date' => 'date'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(strtolower($value));
    }

    public function setSurnameAttribute($value)
    {
        $this->attributes['surname'] = ucfirst(strtolower($value));
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getSurnameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getUserTypeAttribute($value)
    {
        return ucfirst($value);
    }

    public function getSubscriptionTypeAttribute($value)
    {
        return ucfirst($value);
    }

    public function preferredCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'preferred_category_id');
    }

    public function courseSubscriptions()
    {
        return $this->hasMany(ClientCourseSubscription::class);
    }

    public function getCoursesCountAttribute()
    {
        return $this->courseSubscriptions()->count();
    }

    public function trainingRegistrations()
    {
        return $this->hasMany(TrainingRegistration::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->surname}";
    }

    public function getRegisteredAtAttribute()
    {
        return "{$this->registered_date} {$this->registered_time}";
    }

    public function isSubscribedTo($courseId)
    {
        return Cache::remember("user_{$this->id}_enrolled_in_{$courseId}", now()->addSeconds(0.5), function() use ($courseId) {
            return $this->courseSubscriptions()
                ->where('course_id', $courseId)
                ->exists();
        });
    }

    public function hasActiveSubscription()
    {
        return $this->subscription_expiry && 
            $this->subscription_expiry->isFuture();
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'client_course_subscriptions')->withPivot(['progress', 'current_episode_id'])->withTimestamps();
    }
}