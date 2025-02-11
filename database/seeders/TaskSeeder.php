<?php

namespace Database\Seeders;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()
            ->for(User::all()->random(), 'creator')
            ->for(User::all()->random(), 'executer')
            ->for(TaskStatus::all()->random(), 'status')
            ->create(
                [
                    'name' => 'документация',
                    'description' => 'Задача которая касается документации',
                ],
            )->labels()->attach(Label::all()->random());

        Task::factory()
            ->for(User::all()->random(), 'creator')
            ->for(User::all()->random(), 'executer')
            ->for(TaskStatus::all()->random(), 'status')
            ->create(
                [
                    'name' => 'дубликат',
                    'description' => 'Повтор другой задачи',
                ],
            )->labels()->attach(Label::all()->random());

        Task::factory()
            ->for(User::all()->random(), 'creator')
            ->for(User::all()->random(), 'executer')
            ->for(TaskStatus::all()->random(), 'status')
            ->create(
                [
                    'name' => 'доработка',
                    'description' => 'Новая фича, которую нужно запилить',
                ],
            )->labels()->attach(Label::all()->random());
    }
}
