<?php

namespace App\Http\Requests;

use App\Traits\AppResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AppRequest extends FormRequest
{
    use AppResponse;

    public function authorize(): bool
    {
        return Auth::check();
    }

    protected function failedValidation(Validator $validator)
    {
        return $this->responseJson($validator->errors(), 422);
    }
}
