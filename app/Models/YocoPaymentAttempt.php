<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YocoPaymentAttempt extends Model
{
    use HasFactory;

    protected $table = 'yoco_payment_attempts';

    protected $fillable = [
        'client_id',
        'plan_id',
        'amount',
        'yoco_payment_id',
        'status',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'amount' => 'decimal:2'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(TrainingType::class, 'plan_id');
    }
}