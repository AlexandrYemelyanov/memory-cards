<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Groups extends Model
{
    protected $fillable = ['name', 'user_id'];

    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($group) {
            $group->user_id = Auth::id();
        });
    }

    public static function groupExist(int $group_id)
    {
        return self::where('id', $group_id)->exists();
    }

    public static function getAll()
    {
        return self::orderBy('name', 'asc')->get();
    }
}
