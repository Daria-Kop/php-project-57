<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testTaskPage(): void
    {
        $response = $this->get(route('task.index'));

        $response->assertStatus(200);
    }

    /**
     * @throws \JsonException
     */
    public function testTaskCreate(): void
    {
        $user = User::factory()->create();
        $userId = $user->id;

        $this
            ->actingAs($user)
            ->get(route('profile.edit'));

        $taskStatus = TaskStatus::factory()->create();
        $statusId = $taskStatus->id;
        $task = Task::factory()->create([
            'status_id' => $taskStatus->id,
            'assigned_to_id' => $user->id,
            'created_by_id' => $user->id,
        ]);
        $response = $this
            ->post(route('task.create'), [
                'name' => 'Test Task',
                'description' => 'Test Description',
                'status_id' => $statusId,
                'assigned_to_id' => $userId,
                'labels' => [1, 2],
            ]);
        $response
            ->assertSessionHasNoErrors()->assertRedirect(route('task.index'));

        $this->assertDatabaseHas('tasks', [
            'name' => "Test Task",
        ]);
    }


    /**
     * @throws \JsonException
     */
    public function testTaskUpdate(): void
    {
        $user = User::factory()->create();

        $status = TaskStatus::factory()->create();
        $task = Task::factory()->create([
            'status_id' => $status->id,
            'assigned_to_id' => $user->id,
            'created_by_id' => $user->id,
        ]);

        $response = $this
            ->patch(route('task.update', ['task' => $task]), [
                'name' => 'Test Task',
                'description' => 'Test Description',
                'status_id' => $status->id,
                'assigned_to_id' => $user->id,
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('task.index'));

        $this->assertDatabaseHas('tasks', [
            'description' => 'Test Description',
        ]);
    }

    /**
     * @throws \JsonException
     */
    public function testTaskDelete(): void
    {
        $user = User::factory()->create();
        $this
            ->actingAs($user)
            ->get(route('profile.edit'));

        $status = TaskStatus::factory()->create();
        $task = Task::factory()->create([
            'status_id' => $status->id,
            'assigned_to_id' => $user->id,
            'created_by_id' => $user->id,
        ]);

        $response = $this
            ->delete(route('task.destroy', ['task' => $task]));
        $response->assertSessionHasNoErrors();
        $this->assertModelMissing($task);
    }
}
