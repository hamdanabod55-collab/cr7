<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DashboardItem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DashboardItem::query()->delete();

        $items = [
            [
                'title' => 'Neon PostgreSQL Connection',
                'category' => 'Infrastructure',
                'status' => 'Operational',
                'metric_value' => 100,
                'description' => 'Managed cloud PostgreSQL database hosted on Neon Free Tier.',
            ],
            [
                'title' => 'Vercel Serverless Function Deployment',
                'category' => 'Cloud Hosting',
                'status' => 'Operational',
                'metric_value' => 98,
                'description' => 'Laravel PHP serverless entry point optimized for Vercel edge infrastructure.',
            ],
            [
                'title' => 'University Dashboard API & Blade Interface',
                'category' => 'Application Core',
                'status' => 'Completed',
                'metric_value' => 95,
                'description' => 'Real-time dashboard rendering key performance indicators and CRUD item manager.',
            ],
            [
                'title' => 'Database Migration & Auto-Seeding',
                'category' => 'Database',
                'status' => 'Completed',
                'metric_value' => 100,
                'description' => 'Automated schema migration and initial data seeding script for Neon integration.',
            ],
        ];

        foreach ($items as $item) {
            DashboardItem::create($item);
        }
    }
}
