<?php

namespace App\Models;

use App\Helpers\AppLangHelper;
use App\Scopes\UserScope;
use App\Traits\SerializeData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Groups extends Model
{
    use SerializeData;
    use HasFactory;

    protected $fillable = ['name', 'lang_id', 'user_id', 'qty'];

    /**
     * Boot the model and add global scopes and event listeners.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope());

        static::creating(function ($group) {
            if (empty($group->user_id)) {
                $group->user_id = Auth::id();
            }
            if (empty($group->lang_id)) {
                $group->lang_id = AppLangHelper::getId();
            }
        });
    }

    /**
     * Get all groups by language ID.
     *
     * @param int $lang_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAll($lang_id)
    {
        return self::where('lang_id', $lang_id)->orderBy('name', 'asc')->get();
    }
}
