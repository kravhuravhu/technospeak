<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssistanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'task_type',
        'description',
        'deadline',
        'attachments',
        'status',
        'assigned_to',
        'hours_estimated',
        'payment_id'
    ];

    protected $casts = [
        'deadline' => 'date',
        'attachments' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
} 