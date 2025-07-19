<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueResponse extends Model
{
    protected $table = 'issue_responses';
    
    protected $fillable = [
        'issue_id',
        'admin_id',
        'response_type',
        'content'
    ];
    
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}