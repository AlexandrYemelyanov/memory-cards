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

class CardControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Langs $lang;
    private Groups $group;
    private string $foreign_word;
    private string $translation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->lang = Langs::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->group = Groups::factory()->create([
            'user_id' => $this->user->id,
            'lang_id' => $this->lang->id,
        ]);

        $this->foreign_word = fake()->word();
        $this->translation = fake()->word();
    }

    public function testCreateCard()
    {
        $response = $this->post('/cards/add', [
            'foreign_word' => $this->foreign_word,
            'translation' => $this->translation,
            'group_id' => $this->group->id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('memory_cards', [
            'foreign_word' => $this->foreign_word,
            'translation' => $this->translation,
            'group_id' => $this->group->id,
        ]);
    }

    public function testUpdateCard()
    {
        $card = MemoryCard::factory()->create([
            'group_id' => $this->group->id,
        ]);

        $response = $this->post("/cards/update/{$card->id}", [
            'foreign_word' => $this->foreign_word,
            'translation' => $this->translation,
            'group_id' => $this->group->id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('memory_cards', [
            'foreign_word' => $this->foreign_word,
            'translation' => $this->translation,
            'group_id' => $this->group->id,
        ]);
    }

    public function testDestroyCard()
    {
        $card = MemoryCard::factory()->create([
            'foreign_word' => $this->foreign_word,
            'translation' => $this->translation,
            'group_id' => $this->group->id,
        ]);

        $response = $this->get("/cards/remove/{$card->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('memory_cards', [
            'id' => $card->id,
        ]);
    }

    public function testMoveCardsBetweenGroups()
    {
        $group_from = $this->group->id;

        $new_group = Groups::factory()->create([
            'user_id' => $this->user->id,
            'lang_id' => $this->lang->id,
        ]);
        $group_to = $new_group->id;

        MemoryCard::factory()->count(3)->create(['group_id' => $group_from]);

        $response = $this->post('/groups/move', [
            'from' => $group_from,
            'to' => $group_to,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('memory_cards', [
            'group_id' => $group_to,
        ]);
    }

    public function testImportCsv()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->createWithContent('test.csv', "Test,Translation\nTest2,Translation2");

        $response = $this->post('/cards/import/csv', [
            'csv_file' => $file,
            'group_app' => $this->group->id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('memory_cards', [
            'foreign_word' => 'Test',
            'translation' => 'Translation',
            'group_id' => $this->group->id,
        ]);
        $this->assertDatabaseHas('memory_cards', [
            'foreign_word' => 'Test2',
            'translation' => 'Translation2',
            'group_id' => $this->group->id,
        ]);
    }
}

