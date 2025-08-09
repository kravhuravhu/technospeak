<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'client_course_subscriptions';

    protected $fillable = [
        'client_id',
        'course_id',
        'course_uuid',
        'payment_status',
        'progress',
        'current_episode_id',
        'completed'
    ];

    const CREATED_AT = 'subscribed_at';
    const UPDATED_AT = 'updated_at';

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function isActive()
    {
            return $this->payment_status === 'paid' || 
               ($this->payment_status === 'free' && !$this->completed);
    }
}
