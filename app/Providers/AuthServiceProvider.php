<?php

namespace App\Providers;

use App\Models\TaskStatus; // Импортируем модель TaskStatus
use App\Policies\TaskStatusPolicy; // Импортируем политику TaskStatusPolicy
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Список привязок политик
     */
    protected $policies = [
        TaskStatus::class => TaskStatusPolicy::class, // Привязываем модель к политике
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->registerPolicies(); // Регистрация политик
    }
}
