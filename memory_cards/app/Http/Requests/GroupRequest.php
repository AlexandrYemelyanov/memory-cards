<?php

namespace App\Http\Requests;

class GroupRequest extends AppRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
        ];
    }
}
