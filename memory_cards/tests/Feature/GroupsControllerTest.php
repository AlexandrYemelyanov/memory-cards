<?php

namespace Tests\Feature;

use App\Models\Groups;
use App\Models\Langs;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->lang = Langs::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $this->user->learn_lang = $this->lang->loc;
        $this->user->save();

        $this->loc = fake()->languageCode();
        $this->lang_app = fake()->languageCode();
        $this->name = fake()->word();
    }

    public function testCreateGroup()
    {
        $response = $this->post('/groups/new', [
            'qty' => 0,
            'name' => $this->name,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('groups', [
            'name' => $this->name,
        ]);
    }

    public function testUpdateGroup()
    {
        $group = Groups::factory()->create([
            'user_id' => $this->user->id,
            'lang_id' => $this->lang->id,
        ]);

        $response = $this->post("/groups/save/{$group->id}", [
            'name' => $this->name,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('groups', [
            'name' => $this->name,
        ]);
    }

    public function testDestroyGroup()
    {
        $group = Groups::factory()->create([
            'user_id' => $this->user->id,
            'lang_id' => $this->lang->id,
        ]);

        $response = $this->get("/groups/remove/{$group->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('groups', [
            'id' => $group->id,
        ]);
    }

    public function testSetGroup()
    {
        $group_id = fake()->numberBetween(1,100);
        $response = $this->post('/groups/set', [
            'group_app' => $group_id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'current_group' => $group_id,
        ]);
    }
}
