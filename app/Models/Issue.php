<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issues';
    
    protected $fillable = [
        'client_id',
        'title',
        'description',
        'category',
        'urgency',
        'status'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    // Relationship to client
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    
    // Relationship to assignments
    public function assignments()
    {
        return $this->hasMany(IssueAssignment::class, 'issue_id');
    }
    
    // Relationship to responses
    public function responses()
    {
        return $this->hasMany(IssueResponse::class, 'issue_id');
    }
    
    // Urgency levels
    public static function urgencyLevels()
    {
        return [
            'low' => 'Low (Whenever you can)',
            'medium' => 'Medium (Need help soon)',
            'high' => 'High (Critical issue!)'
        ];
    }
    
    // Categories
    public static function categories()
    {
        return [
            'microsoft' => 'Microsoft Products (Word, Excel, etc.)',
            'google' => 'Google Workspace',
            'canva' => 'Canva Design',
            'system' => 'Computer/System Issues',
            'general' => 'General Tech Problem',
            'other' => 'Other'
        ];
    }
}