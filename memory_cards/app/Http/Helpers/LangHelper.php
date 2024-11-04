<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Lang;

class LangHelper
{
    public static function get($mess_id)
    {
        return Lang::get('messages.'.$mess_id);
    }
}
