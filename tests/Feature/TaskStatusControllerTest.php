<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    protected TaskStatus $taskStatus;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->taskStatus = TaskStatus::factory()->create();
    }

    public static function pathProvider(): array
    {
        return [
            ['task_statuses.index', [], 200],
            ['task_statuses.create', [], 302],
            ['task_statuses.edit', ['task_status' => 1], 302],
        ];
    }

    #[DataProvider('pathProvider')]
    public function testAccessGuest(string $path, array $param, int $code)
    {
        auth()->logout();
        $response = $this->get(route($path, $param));
        $response->assertStatus($code);
    }

    public function testIndex()
    {
        TaskStatus::factory()->count(10)->create();
        $response = $this->get(route('task_statuses.index'));

        $response->assertStatus(200);
        $this->assertCount(11, $response->getOriginalContent()->getData()['taskStatuses']); // 1 + 10 созданных статусов
    }

    public function testCreate()
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertStatus(200); // просто проверяем статус
    }

    public function testEdit()
    {
        $response = $this->get(route('task_statuses.edit', ['task_status' => $this->taskStatus->id]));
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $taskStatus = TaskStatus::factory()->make();
        $response = $this->post(route('task_statuses.store'), ['name' => $taskStatus->name]); // Корректируем параметры

        $response->assertStatus(302);
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['name' => $taskStatus->name]);
    }

    public function testUpdate()
    {
        $updatedData = ['name' => 'Updated Name'];

        $response = $this->patch(route('task_statuses.update', ['task_status' => $this->taskStatus->id]), $updatedData);

        $response->assertStatus(302);
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $updatedData);
    }

    public function testDestroy()
    {
        $response = $this->delete(route('task_statuses.destroy', ['task_status' => $this->taskStatus->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertModelMissing($this->taskStatus);
    }

    public function testDestroyTaskStatusInUse()
    {
        Task::factory()->create(['status_id' => $this->taskStatus->id]);
        $response = $this->delete(route('task_statuses.destroy', ['task_status' => $this->taskStatus->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertModelExists($this->taskStatus);
    }

    public function testValidate()
    {
        $validateProvider = [
            ['post', 'task_statuses.index', []],
            ['patch', 'task_statuses.update', ['task_status' => $this->taskStatus]],
        ];

        foreach ($validateProvider as [$method, $path, $param]) {
            $response = $this->call($method, route($path, $param));
            $response->assertStatus(302);
            $response->assertRedirect(route('home'));
            $response->assertSessionHasErrors(['name']);
        }
    }
}
