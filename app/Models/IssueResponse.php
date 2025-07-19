<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueResponse extends Model
{
    protected $table = 'issue_responses';
    
    protected $fillable = [
        'issue_id',
        'responder_id',
        'response_type',
        'content',
        'is_customer_visible'
    ];
    
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
    
    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id');
    }
}