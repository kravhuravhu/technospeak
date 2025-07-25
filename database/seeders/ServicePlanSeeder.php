<?php

namespace Database\Seeders;

use App\Models\ServicePlan;
use Illuminate\Database\Seeder;

class ServicePlanSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Tech Teasers',
                'description' => 'Free access to social media videos',
                'rate_student' => 0,
                'rate_business' => 0,
                'is_subscription' => true,
                'is_hourly' => false
            ],
            [
                'name' => 'TechVault Access',
                'description' => 'Premium subscription with full access',
                'rate_student' => 350,
                'rate_business' => 400,
                'is_subscription' => true,
                'is_hourly' => false
            ],
            [
                'name' => 'Formal Training',
                'description' => '40-hour comprehensive training course',
                'rate_student' => 2500,
                'rate_business' => 3500,
                'is_subscription' => false,
                'is_hourly' => false
            ],
            [
                'name' => 'Personal Guide',
                'description' => 'One-on-one tutoring sessions',
                'rate_student' => 110,
                'rate_business' => 210,
                'is_subscription' => false,
                'is_hourly' => true
            ],
            [
                'name' => 'Task Assistance',
                'description' => 'Hands-on task completion help',
                'rate_student' => 100,
                'rate_business' => 250,
                'is_subscription' => false,
                'is_hourly' => true
            ],
            [
                'name' => 'Group Q/A',
                'description' => 'Free group question and answer sessions',
                'rate_student' => 0,
                'rate_business' => 0,
                'is_subscription' => false,
                'is_hourly' => false
            ],
            [
                'name' => 'Group Consultation',
                'description' => 'Paid group consultation sessions',
                'rate_student' => 130,
                'rate_business' => 200,
                'is_subscription' => false,
                'is_hourly' => true
            ]
        ];

        foreach ($plans as $plan) {
            ServicePlan::create($plan);
        }
    }
}