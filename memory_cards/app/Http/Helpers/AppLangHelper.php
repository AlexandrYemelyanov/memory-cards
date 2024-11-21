<?php

namespace App\Http\Helpers;

use App\Models\Langs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AppLangHelper
{
    public static function setLocale(Request $request): void
    {
        if ($request->isMethod('post') && $request->has('lang_app')) {
            $locale = $request->post('lang_app');
            Cookie::queue('lang_app', $locale, 518400);
            GroupsHelper::removeCurrentGroup();
        }
    }

    public static function getLocale(): string
    {
        return Cookie::get('lang_app', env('APP_LOCALE'));
    }

    public static function getId(): int
    {
        $loc = Cookie::get('lang_app', env('APP_LOCALE'));
        return (int) Langs::getIdByLang($loc);
    }

    public static function getLang(): Langs
    {
        return Langs::find(self::getId());
    }
}
