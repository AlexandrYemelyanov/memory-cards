<?php

namespace App\Http\Helpers;

use App\Models\Groups;
use App\Models\MemoryCard;
use Illuminate\Support\Facades\Cookie;

class GroupsHelper
{
    public static function setCurrentGroup(int $group_id): void
    {
        Cookie::queue('view-group', $group_id, 518400);
    }

    public static function getCurrentGroup(): int
    {
        return (int) Cookie::get('view-group', 0);
    }

    public static function removeCurrentGroup()
    {
        Cookie::queue(Cookie::forget('view-group'));
    }

    public static function getGroups(int $lang_id = 0): array
    {
        if (empty($lang_id)) {
            $lang_id = AppLangHelper::getId();
        }
        if (empty($lang_id)) {
            return [];
        }
        $groups = Groups::getAll($lang_id)->toArray();
        $curr_group_id = self::getCurrentGroup();
        if (!empty($groups)) {
            $group_keys = array_column($groups, 'id');
            $group_index = array_search($curr_group_id, $group_keys);
            if ($group_index === false) {
                $curr_group_id = $group_keys[0];
                self::setCurrentGroup($curr_group_id);
            }
        }

        return [
            'curr_group_id' => $curr_group_id,
            'groups' => $groups
        ];
    }

    public static function updateQty(int $group_id)
    {
        $qty = (int) MemoryCard::where('group_id', $group_id)->count();
        Groups::where('id', $group_id)->update(['qty' => $qty]);
    }
}
