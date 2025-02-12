<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelTest extends TestCase
{
    public function testLabelsPage(): void
    {
        $response = $this->get(route('label.index'));

        $response->assertStatus(200);
    }

    /**
     * @throws \JsonException
     */
    public function testLabelCreate(): void
    {
        $response = $this
            ->post(route('label.index'), [
                'name' => 'Test Label',
                'description' => 'Test Description',
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('label.index'));

        $this->assertDatabaseHas('labels', [
            'description' => 'Test Description',
        ]);
    }

    public function testLabelSeed(): void
    {
        $this->seed();
        $this->assertDatabaseHas('labels', [
            'name' => 'ошибка',
        ]);
    }

    /**
     * @throws \JsonException
     */
    public function testLabelUpdate(): void
    {
        $label = Label::factory()->create();
        $response = $this
            ->patch(route('label.update', ['label' => $label]), [
                'name' => 'Test Label',
                'description' => 'Test Description',
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('label.index'));

        $this->assertDatabaseHas('labels', [
            'description' => 'Test Description',
        ]);
    }

    /**
     * @throws \JsonException
     */
    public function testLabelDelete(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('profile.edit'));

        $label = Label::factory()->create();
        $response = $this
            ->delete(route('label.destroy', ['label' => $label]));
        $response->assertSessionHasNoErrors();
        $this->assertModelMissing($label);
    }
}
