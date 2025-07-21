<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issues';
    
        protected $fillable = [
        'client_id', 'email', 'title', 'description', 'category', 
        'urgency', 'status', 'resolution_details', 'admin_notes', 
        'assigned_to', 'resolved_at', 'closed_at'
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime'
    ];
    
    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id2');
    }

    public function assignedTo()
    {
        return $this->belongsTo(Instructor::class, 'assigned_to');
    }

    public function responses()
    {
        return $this->hasMany(IssueResponse::class);
    }

    public function assignments()
    {
        return $this->hasMany(IssueAssignment::class);
    }
    
    // Helpers
    public static function categories()
    {
        return [
            'microsoft' => 'Microsoft Products',
            'google' => 'Google Workspace',
            'canva' => 'Canva Design',
            'system' => 'Computer/System Issues',
            'general' => 'General Tech Problem'
        ];
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'assigned_to');
    }

    public function currentAssignment()
    {
        return $this->hasOne(IssueAssignment::class)->where('status', 'active')->latest();
    }
}
