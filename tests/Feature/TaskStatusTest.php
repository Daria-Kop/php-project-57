<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JsonException;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    public function testTaskStatusPage(): void
    {
        $response = $this->get(route('status.index'));

        $response->assertStatus(200);
    }

    /**
     * @throws JsonException
     */
    public function testTaskStatusCreate(): void
    {
        $response = $this
            ->post(route('status.create'), [
                'name' => 'Test Label',
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('status.index'));

        $this->assertDatabaseHas('task_statuses', [
            'name' => 'Test Label',
        ]);
    }

    public function testTaskStatusSeed(): void
    {
        $this->seed();
        $this->assertDatabaseHas('task_statuses', [
            'name' => 'новый',
        ]);
    }

    /**
     * @throws JsonException
     */
    public function testTaskStatusUpdate(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $response = $this
            ->patch(route('status.update', ['task_status' => $taskStatus]), [
                'name' => 'Test Status',
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('status.index'));

        $this->assertDatabaseHas('task_statuses', [
            'name' => 'Test Status',
        ]);
    }

    /**
     * @throws JsonException
     */
    public function testTaskStatusDelete(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('profile.edit'));

        $taskStatus = TaskStatus::factory()->create();
        $response = $this
            ->delete(route('status.destroy', ['task_status' => $taskStatus]));
        $response->assertSessionHasNoErrors();
        $this->assertModelMissing($taskStatus);
    }
}
