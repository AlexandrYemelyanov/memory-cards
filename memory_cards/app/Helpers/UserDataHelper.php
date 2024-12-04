<?php

namespace App\Helpers;

use App\Models\Groups;
use App\Models\Langs;
use App\Models\MemoryCard;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserDataHelper
{
    public static function import(int $user_id): bool
    {
        $jsonData = json_decode(Storage::disk('local')->get('user_' . $user_id . '.json'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        DB::beginTransaction();
        try {
            // Import user
            User::where('id', $jsonData['user']['id'])->delete();
            $user_id = User::insertGetId($jsonData['user']);
            $user_data = ['user_id' => $user_id];

            // Import languages
            foreach ($jsonData['langs'] as $lang) {
                $data = array_merge($lang, $user_data);
                Langs::insert($data);
            }

            // Import groups
            foreach ($jsonData['groups'] as $group) {
                $data = array_merge($group, $user_data);
                Groups::insert($data);
            }

            // Import memory cards
            foreach ($jsonData['memory_cards'] as $memoryCard) {
                $data = array_merge($memoryCard, $user_data);
                MemoryCard::insert($data);
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function export(int $user_id): bool
    {
        $user = User::find($user_id);
        if (!$user) {
            return false;
        }

        // Fetch user data
        $userData = [
            'user' => array_merge(['password' => $user->password], $user->toArray()),
            'langs' => Langs::where('user_id', $user_id)->get()->toArray(),
            'groups' => Groups::where('user_id', $user_id)->get()->toArray(),
            'memory_cards' => MemoryCard::where('user_id', $user_id)->get()->toArray(),
        ];

        $userFileName = 'user_' . $user_id . '.json';
        Storage::disk('local')->put($userFileName, json_encode($userData));

        return true;
    }
}
