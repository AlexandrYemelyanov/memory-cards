<?php

namespace App\Models;

use App\Traits\SerializeData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Scopes\UserScope;

class Langs extends Model
{
    protected $fillable = ['loc', 'name'];

    use HasFactory, SerializeData;

    /**
     * Boot the model and apply global scopes.
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(new UserScope());

        static::creating(function ($lang) {
            $lang->user_id = Auth::id();
        });
    }

    /**
     * Get the ID by language code.
     *
     * @param string $lang Language code.
     * @return int ID of the language or 0 if not found.
     */
    public static function getIdByLang(string $lang)
    {
        $res = self::where('loc', $lang)->get('id');
        return $res->isEmpty() ? 0 : $res->first()->id;
    }

    /**
     * Retrieve all languages ordered by name.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAll()
    {
        return self::orderBy('name', 'asc')->get();
    }
}
