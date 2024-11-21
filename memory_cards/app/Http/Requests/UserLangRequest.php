<?php

namespace App\Http\Requests;

class UserLangRequest extends AppRequest
{
    public function rules()
    {
        return [
            'loc' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'loc.required' => 'Locale is required',
        ];
    }

}
