<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issues';
    
    protected $fillable = [
        'client_id',
        'email',
        'title',
        'description',
        'category',
        'urgency',
        'status',
        'resolution_details',
        'admin_notes',
        'assigned_to'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime'
    ];
    
    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    
    public function assignments()
    {
        return $this->hasMany(IssueAssignment::class);
    }
    
    public function responses()
    {
        return $this->hasMany(IssueResponse::class);
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
}
