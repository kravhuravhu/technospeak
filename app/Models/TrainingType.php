<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_group_session',
        'max_participants'
    ];

    protected $casts = [
        'is_group_session' => 'boolean',
        'max_participants' => 'integer'
    ];

    public function sessions()
    {
        return $this->hasMany(TrainingSession::class, 'type_id');
    }
}