<?php

namespace Tests\Feature;

use App\Models\Groups;
use App\Models\Langs;
use Tests\TestCase;
use App\Models\User;
use App\Models\MemoryCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\Auth;

class LangsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->loc = fake()->languageCode();
        $this->lang_app = fake()->languageCode();
        $this->name = fake()->countryCode();
    }

    public function testCreateLang()
    {
        $response = $this->post('/langs/new', [
            'loc' => $this->loc,
            'lang_app' => $this->lang_app,
            'name' => $this->name,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('langs', [
            'loc' => $this->loc,
            'name' => $this->name,
        ]);
    }

    public function testUpdateLang()
    {
        $lang = Langs::factory()->create();
        $response = $this->post("/langs/save/{$lang->id}", [
            'loc' => $this->loc,
            'name' => $this->name,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('langs', [
            'loc' => $this->loc,
            'name' => $this->name,
        ]);
    }

    public function testDestroyLang()
    {
        $lang = Langs::factory()->create();
        $response = $this->get("/langs/remove/{$lang->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('langs', [
            'id' => $lang->id,
        ]);
    }

    public function testSetLang()
    {
        $response = $this->post('/langs/set', [
            'lang_app' => $this->lang_app,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'learn_lang' => $this->lang_app,
        ]);
    }
}
