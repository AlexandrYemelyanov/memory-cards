<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Langs extends Model
{
    protected $fillable = ['loc', 'name'];

    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($lang) {
            $lang->user_id = Auth::id();
        });
    }

    public static function langExist(int $lang_id)
    {
        return self::where('id', $lang_id)->exists();
    }

    public static function langExistByLang(string $lang)
    {
        return self::where('loc', $lang)->exists();
    }

    public static function getIdByLang(string $lang)
    {
        $res =  self::where('loc', $lang)->get('id');
        return $res->isEmpty() ? 0 : $res->first()->id;
    }

    public static function getAll()
    {
        return self::orderBy('name', 'asc')->get();
    }
}
