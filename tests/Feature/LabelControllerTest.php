<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    protected Label $label;

    public function setUp(): void
    {
        parent::setUp();
        $this->label = Label::factory()->create();
    }

    public static function pathProvider(): array
    {
        return [
            ['labels.index', [], 200, 'labels.index'],
            ['labels.create', [], 200],
            ['labels.edit', ['label' => 1], 200],
        ];
    }

    #[DataProvider('pathProvider')]
    public function testAccessGuest(string $path, array $param, int $code, ?string $view = null)
    {
        auth()->logout();
        $response = $this->get(route($path, $param));
        $response->assertStatus($code);
        if ($view !== null) {
            $response->assertViewIs($view);
            $response->assertViewHas('labels');
        }
    }

    public function testIndex()
    {
        Label::factory()->count(10)->create();
        $response = $this->get(route('labels.index'));
        $response->assertStatus(200);
        $response->assertViewIs('labels.index');
        $response->assertViewHas('labels', Label::all());
    }

    public function testCreate()
    {
        $response = $this->get(route('labels.create'));
        $response->assertStatus(200);
        $response->assertViewIs('labels.create');
    }

    public function testEdit()
    {
        $response = $this->get(route('labels.edit', ['label' => $this->label->id]));
        $response->assertStatus(200);
        $response->assertViewIs('labels.edit');
        $response->assertViewHas('label', $this->label);
    }

    public function testStore()
    {
        $label = Label::factory()->make();
        $response = $this->post(route('labels.store'), ['name' => $label->name]);
        $response->assertStatus(302);
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['name' => $label->name]);
    }

    public function testUpdate()
    {
        $updatedData = ['name' => fake()->word];
        $response = $this->patch(route('labels.update', ['label' => $this->label->id]), $updatedData);
        $response->assertStatus(302);
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $updatedData);
    }

    public function testDestroy()
    {
        $response = $this->delete(route('labels.destroy', ['label' => $this->label->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('labels.index'));
        $this->assertModelMissing($this->label);
    }

    public function testDestroyLabelInUse()
    {
        TaskStatus::factory()->create();
        $task = Task::factory()->create();
        $task->labels()->attach($this->label->id);
        $response = $this->delete(route('labels.destroy', ['label' => $this->label->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('labels.index'));
        $this->assertModelExists($this->label);
    }

    public function testValidateStore()
    {
        $response = $this->post(route('labels.store'), []);
        $response->assertSessionHasErrors(['name']);
    }

    public function testValidateUpdate()
    {
        $response = $this->patch(route('labels.update', ['label' => $this->label->id]), []);
        $response->assertSessionHasErrors(['name']);
    }

    protected function authenticateUser(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function testAuthenticatedUserCanAccessEdit()
    {
        $this->authenticateUser();
        $response = $this->get(route('labels.edit', ['label' => $this->label->id]));
        $response->assertStatus(200);
        $response->assertViewIs('labels.edit');
        $response->assertViewHas('label', $this->label);
    }
}
