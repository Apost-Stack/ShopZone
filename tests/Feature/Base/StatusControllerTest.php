<?php

namespace Tests\Feature\Base;

use App\Models\Base\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_status_list()
    {
        Status::factory()->count(3)->create();

        $response = $this->get(route('statuses.index'));

        $response->assertStatus(200);
        $response->assertViewIs(\App\Common\CommonAdminView::getStatusListView());
        $response->assertViewHas('statuses');
    }

    /** @test */
    public function it_displays_create_form()
    {
        $response = $this->get(route('statuses.create'));

        $response->assertStatus(200);
        $response->assertViewIs(\App\Common\CommonAdminView::getStatusEditOrCreateView());
    }

    /** @test */
    public function it_stores_a_status()
    {
        $data = ['name' => 'Active'];

        $response = $this->post(route('statuses.store'), $data);

        $this->assertDatabaseHas('statuses', $data);
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Status created successfully.');
    }

    /** @test */
    public function it_shows_a_status()
    {
        $status = Status::factory()->create();

        $response = $this->get(route('statuses.show', $status->id));

        $response->assertStatus(200);
        $response->assertViewIs(\App\Common\CommonAdminView::getStatusShowView());
        $response->assertViewHas('status', $status);
    }

    /** @test */
    public function it_edits_a_status()
    {
        $status = Status::factory()->create();

        $response = $this->get(route('statuses.edit', $status->id));

        $response->assertStatus(200);
        $response->assertViewIs(\App\Common\CommonAdminView::getStatusEditOrCreateView());
        $response->assertViewHas('status', $status);
    }

    /** @test */
    public function it_updates_a_status()
    {
        $status = Status::factory()->create(['name' => 'Old Name']);

        $response = $this->put(route('statuses.update', $status->id), [
            'name' => 'New Name'
        ]);

        $this->assertDatabaseHas('statuses', ['id' => $status->id, 'name' => 'New Name']);
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Status updated successfully.');
    }

    /** @test */
    public function it_deletes_a_status()
    {
        $status = Status::factory()->create();

        $response = $this->delete(route('statuses.destroy', $status->id));

        $this->assertDatabaseMissing('statuses', ['id' => $status->id]);
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Status deleted successfully.');
    }
}
