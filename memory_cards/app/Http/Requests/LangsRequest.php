<?php

namespace App\Http\Requests;

class LangsRequest extends AppRequest
{
    public function rules()
    {
        return [
            'loc' => 'required|string',
            'name' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'loc.required' => 'Locale is required',
            'name.required' => 'Name is required',
        ];
    }
}
