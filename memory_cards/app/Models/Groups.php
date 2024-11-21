<?php

namespace App\Models;

use App\Http\Helpers\AppLangHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Groups extends Model
{
    protected $fillable = ['name', 'lang_id', 'qty'];

    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($group) {
            $group->user_id = Auth::id();
            $group->lang_id = AppLangHelper::getId();
        });
    }

    public static function groupExist(int $group_id)
    {
        return self::where('id', $group_id)->exists();
    }

    public static function getAll($lang_id)
    {
        return self::where('lang_id', $lang_id)->orderBy('name', 'asc')->get();
    }

    public static function destroyByLang(int $lang_id)
    {
        $group_ids = self::where('lang_id', $lang_id)->pluck('id')->toArray();
        self::whereIn('id', $group_ids)->delete();
        return $group_ids;
    }
}
