<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Announcement::create([
            'title' => 'System Maintenance',
            'body' => 'The system will be under maintenance from 12 AM to 2 AM.',
            'type' => 'all',
            'user_ids' => [],
        ]);

        Announcement::create([
            'title' => 'Driver Meeting',
            'body' => 'All drivers are required to attend the meeting on Friday.',
            'type' => 'drivers',
            'user_ids' => [1, 2, 3], // Direct array assignment
        ]);

        Announcement::create([
            'title' => 'New Feature for Riders',
            'body' => 'We have introduced a new ride-scheduling feature.',
            'type' => 'riders',
            'user_ids' => [4, 5], // example rider IDs
        ]);
    }
}
