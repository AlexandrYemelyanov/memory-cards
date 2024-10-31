<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemoryCard;
use App\Models\Groups;
use Illuminate\Http\JsonResponse;
use App\Traits\CardResponse;
use App\Http\Helpers\LangHelper as Lang;


class CardController extends Controller
{
    use CardResponse;

    public function create(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'foreign_word' => 'required|string',
                'translation' => 'required|string',
                'group_id' => 'required|int',
            ]);
            MemoryCard::create($validated);
            return $this->responseJson(Lang::get('card_saved'));
        } catch (\Exception $e) {
            return $this->responseJson($e->getMessage(), 500);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|int',
            'foreign_word' => 'required|string',
            'translation' => 'required|string',
            'group_id' => 'required|int',
        ]);
        if (!MemoryCard::cardExist($validated['id'])) {
            return $this->responseJson('', 500);
        }

        MemoryCard::where('id', $validated['id'])->update($validated);
        return $this->responseJson(Lang::get('card_updated'));
    }

    public function destroy(int $cart_id): JsonResponse
    {
        if (!MemoryCard::cardExist($cart_id)) {
            return $this->responseJson('', 500);
        }

        MemoryCard::destroy($cart_id);
        return $this->responseJson('');
    }

    public function index(Request $request): mixed
    {
        $cards = MemoryCard::where('group_id', $this->getCurrentGroup($request))->orderByRaw('RAND()')->get();
        if (!$cards->count()) {
            return redirect()->route('card.add');
        }
        $data = [
            'cards' => $cards,
            'groups' => Groups::getAll()
        ];
        return view('cards.show', $data);
    }

    private function getCurrentGroup(Request $request)
    {
        $group_cookie = (int) $request->cookie('view-group');
        return MemoryCard::getCountCardsByGroup($group_cookie) ? $group_cookie : MemoryCard::getFirstGroup();
    }

    public function importCsv(Request $request): JsonResponse
    {
        $file = $request->file('csv_file');
        $fileHandle = fopen($file->getPathname(), 'r');
        $cnt = 0;
        while (($row = fgetcsv($fileHandle, 1000, ',')) !== false) {
            MemoryCard::create([
                'foreign_word' => $row[0],
                'translation' => $row[1],
                'group_id' => 0
            ]);
            $cnt++;
        }
        fclose($fileHandle);
        return $this->responseJson(sprintf(Lang::get('imported_qty_cards'), $cnt));
    }
}
