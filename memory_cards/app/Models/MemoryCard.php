<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MemoryCard extends Model
{
    use HasFactory;

    protected $fillable = ['foreign_word', 'translation', 'color', 'user_id', 'group_id'];

    // Генерация случайного цвета при создании карточки
    public static function boot()
    {
        parent::boot();

        static::creating(function ($card) {
            $card->color = self::generateRandomColor();
            $card->user_id = Auth::id();
        });
    }

    public static function generateRandomColor()
    {
        $minBrightness = 0x33;
        $maxBrightness = 0xCC;

        $red = mt_rand($minBrightness, $maxBrightness);
        $green = mt_rand($minBrightness, $maxBrightness);
        $blue = mt_rand($minBrightness, $maxBrightness);

        return sprintf('#%02X%02X%02X', $red, $green, $blue);
    }

    public static function cardExist(int $card_id)
    {
        return self::where('id', $card_id)->exists();
    }

    public static function removeGroup(int $group_id)
    {
        return self::where('group_id', $group_id)->update(['group_id' => null]);
    }

    public static function getCardsByGroup(int $group_id)
    {
        return self::where('group_id', $group_id)->orderByRaw('RAND()')->get();
    }

    public static function getCountCardsByGroup(int $group_id)
    {
        return self::where('group_id', $group_id)->count();
    }

    public static function getFirstGroup()
    {
        $first = self::first();
        return empty($first['group_id']) ? 0 : $first['group_id'];
    }
}
