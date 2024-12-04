<?php

namespace App\Models;

use App\Scopes\UserScope;
use App\Traits\SerializeData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MemoryCard extends Model
{
    use HasFactory;
    use SerializeData;

    protected $fillable = [
        'foreign_word',
        'translation',
        'group_id'
    ];

    /**
     * Boot the model and apply global scope.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope());

        static::creating(function ($card) {
            $card->color = self::generateRandomColor();
            $card->user_id = Auth::id();
        });
    }

    /**
     * Generate a random color in HEX format.
     *
     * @return string
     */
    public static function generateRandomColor()
    {
        $minBrightness = 0x33;
        $maxBrightness = 0xCC;

        $red = mt_rand($minBrightness, $maxBrightness);
        $green = mt_rand($minBrightness, $maxBrightness);
        $blue = mt_rand($minBrightness, $maxBrightness);

        return sprintf('#%02X%02X%02X', $red, $green, $blue);
    }

    /**
     * Retrieve memory cards by their group.
     *
     * @param int $group_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCardsByGroup(int $group_id)
    {
        return self::where('group_id', $group_id)->orderByRaw('RAND()')->get();
    }
}
