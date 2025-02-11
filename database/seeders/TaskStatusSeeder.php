<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = \Carbon\Carbon::now();
        DB::table('task_statuses')->insert([
            'name' => 'новый',
            'created_at' => "$now",
            'updated_at' => "$now",

        ]);

        DB::table('task_statuses')->insert([
            'name' => 'в работе',
            'created_at' => "$now",
            'updated_at' => "$now",

        ]);

        DB::table('task_statuses')->insert([
            'name' => 'на тестировании',
            'created_at' => "$now",
            'updated_at' => "$now",

        ]);

        DB::table('task_statuses')->insert([
            'name' => 'завершен',
            'created_at' => "$now",
            'updated_at' => "$now",

        ]);
    }
}
