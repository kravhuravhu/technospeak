<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueAssignment extends Model
{
    protected $table = 'issue_assignments';
    
    protected $fillable = [
        'issue_id',
        'admin_id',
        'status'
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