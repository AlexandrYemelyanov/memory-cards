<?php

namespace App\Http\Requests;

class GroupRequest extends AppRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
        ];
    }
}
