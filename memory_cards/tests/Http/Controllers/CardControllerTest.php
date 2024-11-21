<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\CardController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CardControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing importCsv method of CardController
     */
    public function testImportCsv()
    {
        // Mock the data
        $testFileContents = "Test,Test\nTest,Test";
        $request = new Request();
        $request->replace([
            'csv_file' => UploadedFile::fake()->createWithContent('test.csv', $testFileContents),
            'group_app' => 100
        ]);

        $cardController = new CardController();
        $response = $cardController->importCsv($request);

        // Assertions
        $this->assertInstanceOf(Illuminate\Http\JsonResponse::class, $response);
        $this->assertDatabaseHas('memory_cards', [
            'foreign_word' => 'Test',
            'translation' => 'Test',
            'group_id' => 100
        ]);
    }
}
