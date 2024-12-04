<?php

namespace App\Http\Requests;

class LangsRequest extends AppRequest
{
    public function rules(): array
    {
        return [
            'loc' => 'required|string',
            'name' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'loc.required' => 'Locale is required',
            'name.required' => 'Name is required',
        ];
    }
}
