<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'description',
        'icon',
        'url'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public static function log($description, $icon = 'fa-info-circle', $url = null)
    {
        $user = auth()->user();
        
        return static::create([
            'user_id' => $user ? $user->id : null,
            'user_type' => $user ? get_class($user) : null,
            'description' => $description,
            'icon' => $icon,
            'url' => $url
        ]);
    }

    public function user()
    {
        if ($this->user_type) {
            return $this->belongsTo($this->user_type, 'user_id');
        }
        return null;
    }
}