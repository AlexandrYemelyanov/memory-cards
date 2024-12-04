<?php

namespace App\Helpers;

use App\Models\Groups;
use App\Models\MemoryCard;
use App\Models\User;

class GroupsHelper
{

    /**
     * Set the current group for the authenticated user.
     *
     * @param int $group_id
     * @return void
     */
    public static function setCurrentGroup(int $group_id): void
    {
        /** @var User $user */
        $user = auth()->user();
        $user?->update(['current_group' => $group_id]);
    }

    /**
     * Get the current group of the authenticated user.
     *
     * @return int
     */
    public static function getCurrentGroup(): int
    {
        return auth()->user()?->current_group ?? 0;
    }

    /**
     * Remove the current group for the authenticated user.
     *
     * @return void
     */
    public static function removeCurrentGroup(): void
    {
        /** @var User $user */
        $user = auth()->user();
        $user?->update(['current_group' => null]);
    }

    /**
     * Retrieve all groups for a specific language.
     *
     * @param int $lang_id
     * @return array
     */
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

    /**
     * Update the quantity for a specific group.
     *
     * @param int $group_id
     * @return void
     */
    public static function updateQty(int $group_id): void
    {
        $qty = (int)MemoryCard::where('group_id', $group_id)->count();
        Groups::where('id', $group_id)->update(['qty' => $qty]);
    }
}
