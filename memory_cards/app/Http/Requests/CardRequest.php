<?php

namespace App\Http\Requests;

class CardRequest extends AppRequest
{
    public function rules(): array
    {
        return [
            'foreign_word' => 'required|string',
            'translation' => 'required|string',
            'group_id' => 'required|int',
        ];
    }

    public function messages(): array
    {
        return [
            'foreign_word.required' => 'foreign_word is required',
            'translation.required' => 'translation is required',
            'group_id.required' => 'group_id is required',
        ];
    }
}
