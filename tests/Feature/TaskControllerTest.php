<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    protected Task $task;

    public function setUp(): void
    {
        parent::setUp();

        $users = User::factory()->count(1)->create();
        TaskStatus::factory()->count(5)->create();
        $this->actingAs($users->random());
        $this->task = Task::factory()->create();
    }

    public static function pathProvider(): array
    {
        return [
            ['tasks.index', [], 200, 'tasks', 'tasks.index'],
            ['tasks.show', ['task' => 1], 200, 'task', 'tasks.show'],
            ['tasks.create', [], 302, ''],
            ['tasks.edit', ['task' => 1], 302, ''],
        ];
    }

    #[DataProvider('pathProvider')]
    public function testAccessGuest(
        string $path,
        array $param,
        int $code,
        string $viewHas,
        ?string $view = null,
    ) {
        auth()->logout();
        $response = $this->get(route($path, $param));

        $response->assertStatus($code);
        if ($view !== null) {
            $response->assertViewIs($view);
            $response->assertViewHas($viewHas);
        }
    }

    public function testIndex()
    {
        Task::factory()->count(10)->create();
        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks instanceof LengthAwarePaginator;
        });
    }

    public function testCreate()
    {
        $response = $this->get(route('tasks.create'));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.create');
    }

    public function testEdit()
    {
        $response = $this->get(route('tasks.edit', ['task' => $this->task->id]));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.edit');
        $response->assertViewHas('task', $this->task);
    }

    public function testStore()
    {
        $task = Task::factory()->make();
        $response = $this->post(route('tasks.store'), $task->toArray());

        $response->assertStatus(302);
        $response->assertRedirectToRoute('tasks.index');
        $this->assertDatabaseHas('tasks', ['name' => $task->name]);
    }

    public function testShow()
    {
        $response = $this->get(route('tasks.show', ['task' => $this->task->id]));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.show');
        $response->assertViewHas('task', $this->task);
    }

    public function testUpdate()
    {
        $updatedData = Task::factory()->make()->only([
            'name',
            'description',
            'status_id',
            'assigned_to_id',
        ]);
        $response = $this->patch(route('tasks.update', ['task' => $this->task->id]), $updatedData);

        $response->assertStatus(302);
        $response->assertRedirectToRoute('tasks.index');
        $this->assertDatabaseHas('tasks', $updatedData);
    }

    public function testDestroy()
    {
        $response = $this->delete(route('tasks.destroy', ['task' => $this->task->id]));

        $response->assertStatus(302);
        $response->assertRedirectToRoute('tasks.index');
        $this->assertModelMissing($this->task);
    }

    public function testDestroyNotOwner()
    {
        $newUser = User::factory()->create();
        $response = $this->actingAs($newUser)->delete(route('tasks.destroy', ['task' => $this->task->id]));

        $response->assertStatus(302);
    }
}
