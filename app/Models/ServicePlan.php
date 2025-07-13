<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePlan extends Model
{
    public function up()
    {
        Schema::create('service_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('rate_student', 10, 2)->nullable();
            $table->decimal('rate_business', 10, 2)->nullable();
            $table->string('stripe_price_id_student')->nullable();
            $table->string('stripe_price_id_business')->nullable();
            $table->boolean('is_subscription')->default(false);
            $table->timestamps();
        });
    }

        protected $fillable = [
        'name',
        'description',
        'rate_student',
        'rate_business',
        'stripe_price_id_student',
        'stripe_price_id_business',
        'is_subscription'
    ];
}
