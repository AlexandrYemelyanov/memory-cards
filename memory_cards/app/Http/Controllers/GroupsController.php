<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use Illuminate\Http\Request;
use App\Traits\CardResponse;
use App\Models\MemoryCard;
use App\Http\Helpers\LangHelper as Lang;

class GroupsController extends Controller
{
    use CardResponse;

    public function index(): mixed
    {
        $groups = Groups::orderBy('name')->get();
        return view('cards.groups', compact('groups'));
    }

    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
            ]);
            $group = Groups::create($validated);
            return $this->responseJson(Lang::get('group_added'), 200, ['group' => $group]);
        } catch (\Exception $e) {
            return $this->responseJson($e->getMessage(), 500);
        }
    }

    public function destroy(int $group_id)
    {
        if (!Groups::groupExist($group_id)) {
            return $this->responseJson('', 500);
        }

        MemoryCard::removeGroup($group_id);
        Groups::destroy($group_id);
        return $this->responseJson('');
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'groups' => 'required|array',
                'groups.*.id' => 'required|int',
                'groups.*.name' => 'required|string',
            ]);

            foreach ($validated['groups'] as $groupData) {
                $group = Groups::find($groupData['id']);
                if ($group) {
                    $group->name = $groupData['name'];
                    $group->save();
                }
            }
            return $this->responseJson(Lang::get('groups_updated'), 200);
        } catch (\Exception $e) {
            return $this->responseJson($e->getMessage(), 500);
        }
    }
}
