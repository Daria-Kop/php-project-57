<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Label;

class LabelPolicy
{
    public function view(User $user, Label $label)
    {
        return true; // пример условия
    }

    public function create(User $user)
    {
        return true; // пример условия
    }

    public function update(User $user, Label $label)
    {
        return true; // пример условия
    }

    public function delete(User $user, Label $label)
    {
        return !$label->tasks()->exists(); // нельзя удалить, если есть задачи, например
    }
}
