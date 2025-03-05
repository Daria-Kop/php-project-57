<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = \Carbon\Carbon::now();
        DB::table('labels')->insert([
            'name' => 'ошибка',
            'description' => 'Какая-то ошибка в коде или проблема с функциональностью',
            'created_at' => "$now",
            'updated_at' => "$now",

        ]);

        DB::table('labels')->insert([
            'name' => 'документация',
            'description' => 'Задача которая касается документации',
            'created_at' => "$now",
            'updated_at' => "$now",

        ]);

        DB::table('labels')->insert([
            'name' => 'дубликат',
            'description' => 'Повтор другой задачи',
            'created_at' => "$now",
            'updated_at' => "$now",

        ]);

        DB::table('labels')->insert([
            'name' => 'доработка',
            'description' => 'Новая фича, которую нужно запилить',
            'created_at' => "$now",
            'updated_at' => "$now",

        ]);
    }
}
