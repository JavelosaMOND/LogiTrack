<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportType;

class ReportTypeSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['name' => 'Daily Accomplishment', 'purpose' => 'Track daily tasks & outputs', 'frequency' => 'Daily', 'sort_order' => 1],
            ['name' => 'Weekly Operations', 'purpose' => 'Summarize weekly activities', 'frequency' => 'Weekly', 'sort_order' => 2],
            ['name' => 'Monthly Financial', 'purpose' => 'Track expenses & budget', 'frequency' => 'Monthly', 'sort_order' => 3],
            ['name' => 'Incident / Issue', 'purpose' => 'Record problems or accidents', 'frequency' => 'As needed', 'sort_order' => 4],
            ['name' => 'Project Progress', 'purpose' => 'Monitor ongoing projects', 'frequency' => 'Weekly / Bi-weekly', 'sort_order' => 5],
            ['name' => 'Attendance / Time Log', 'purpose' => 'Verify employee attendance', 'frequency' => 'Daily', 'sort_order' => 6],
        ];

        foreach ($defaults as $d) {
            ReportType::firstOrCreate(['name' => $d['name']], $d);
        }
    }
}


