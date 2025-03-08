<?php

namespace App\Policies;

use App\Models\TaskStatus;
use App\Models\User;

class TaskStatusPolicy
{
    /**
     * Determine whether the user can create task statuses.
     */
    public function create(User $user): bool
    {
        // Пример: разрешить создание статуса только пользователям с ролью администратора
        return $user->is_admin; // Предполагаем, что у вас есть поле is_admin в модели User
    }

    /**
     * Determine whether the user can update the task status.
     */
    public function update(User $user, TaskStatus $taskStatus): bool
    {
        // Пример: разрешить обновление статуса только пользователям с ролью администратора
        return $user->is_admin; // Проверяем, является ли пользователь администратором
    }

    /**
     * Determine whether the user can delete the task status.
     */
    public function delete(User $user, TaskStatus $taskStatus): bool
    {
        // Пример: разрешить удаление статуса только пользователям с ролью администратора
        return $user->is_admin; // Проверяем, является ли пользователь администратором
    }
}
