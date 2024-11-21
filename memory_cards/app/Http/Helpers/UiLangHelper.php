<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Lang;

class UiLangHelper
{
    public static function get($mess_id)
    {
        return Lang::get('messages.' . $mess_id);
    }

    public static function getLocale(Request $request)
    {
        if ($request->has('lang_ui')) {
            $locale = $request->get('lang_ui');
            Cookie::queue('lang', $locale, 518400);
        } else {
            $locale = $request->cookie('lang', config('app.locale'));
        }

        return $locale;
    }
}
