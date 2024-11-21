<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLangRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserLangController extends AppController
{
    public function __construct(User $model, UserLangRequest $request)
    {
        parent::__construct();
        $this->model = $model;
        $this->request = $request;
    }

    public function updateUserLang(): JsonResponse
    {
        $current_user_model = User::find(Auth::id());
        return $this->saveModel($current_user_model);
    }
}
