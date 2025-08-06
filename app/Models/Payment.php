<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use \App\Models\TrainingRegistration;
use \App\Models\Instructor;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id',
        'client_id',
        'amount',
        'payment_method',
        'status',
        'payable_type',
        'payable_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    const PAYABLE_TYPES = [
        'training' => \App\Models\TrainingSession::class,
        'course' => \App\Models\Course::class,  // premium courses
        'subscription' => \App\Models\TrainingType::class,
    ];

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function getPaymentForAttribute(): string
    {
        if (!$this->payable) {
            $short = class_basename($this->payable_type);
            return $short . ' #' . $this->payable_id;
        }

        return $this->payable->title ?? class_basename($this->payable_type) . ' #' . $this->payable_id;
    }

    public function getPayableTypeNameAttribute(): string
    {
        return array_search($this->payable_type, self::PAYABLE_TYPES) ?: 
               class_basename($this->payable_type);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
    
    public function getDetailedServiceNameAttribute()
    {
        if (!$this->payable) {
            return [
                'type' => ucfirst($this->payable_type),
                'title' => 'N/A'
            ];
        }

        switch ($this->payable_type) {
            case 'training':
                return [
                    'type' => $this->payable->type->name ?? 'Training',
                    'title' => $this->payable->title,
                    'date' => optional($this->payable->scheduled_for)->format('M d, Y'),
                    'instructor' => $this->payable->instructor->name ?? null
                ];
            case 'course':
                return [
                    'type' => 'Course',
                    'title' => $this->payable->title,
                    'category' => $this->payable->category->name ?? 'N/A'
                ];
            case 'subscription':
                return [
                    'type' => 'Subscription',
                    'title' => $this->payable->name,
                    'duration' => 'Quarterly'
                ];
            case 'service':
                return [
                    'type' => 'Service',
                    'title' => $this->payable->name,
                    'hours' => $this->metadata['hours'] ?? null
                ];
            default:
                return [
                    'type' => ucfirst($this->payable_type),
                    'title' => $this->payable->title ?? 'N/A'
                ];
        }
    }

    public function trainingRegistration()
    {
        return $this->hasOne(TrainingRegistration::class, 'payment_id');
    }

    protected static function booted()
    {
        static::updated(function (Payment $payment) {
            if ($payment->payable_type === \App\Models\TrainingSession::class) {
                TrainingRegistration::where([
                    'client_id' => $payment->client_id,
                    'session_id' => $payment->payable_id,
                ])->update([
                    'payment_status' => $payment->status,
                    'payment_id' => $payment->id,
                ]);
            }
        });
    }
}