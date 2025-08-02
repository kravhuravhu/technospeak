<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_group_session',
        'max_participants',
        'student_price',
        'professional_price'
    ];

    protected $casts = [
        'is_group_session' => 'boolean',
        'student_price' => 'decimal:2',
        'professional_price' => 'decimal:2'
    ];

    public function sessions()
    {
        return $this->hasMany(TrainingSession::class, 'type_id');
    }

    public function getPriceForUserType(?string $userType): float
    {
        return $userType === 'Student' ? $this->student_price : $this->professional_price;
    }

    public function getFormattedStudentPriceAttribute()
    {
        return 'R' . number_format($this->student_price, 2);
    }

    public function getFormattedProfessionalPriceAttribute()
    {
        return 'R' . number_format($this->professional_price, 2);
    }
}