<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        'paid_at',
        'payment_for',
        'item_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    const PAYMENT_FOR_COURSE = 'course';
    const PAYMENT_FOR_TRAINING = 'training_session';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function item()
    {
        if ($this->payment_for === self::PAYMENT_FOR_COURSE) {
            return $this->belongsTo(Course::class, 'item_id');
        }
        return $this->belongsTo(TrainingSession::class, 'item_id');
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'paid_at' => now()
        ]);
    }

    public function markAsFailed()
    {
        $this->update([
            'status' => self::STATUS_FAILED
        ]);
    }
}