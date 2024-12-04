<?php

namespace App\Http\Requests;

class UserLangRequest extends AppRequest
{
    public function rules(): array
    {
        return [
            'loc' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'loc.required' => 'Locale is required',
        ];
    }

}
