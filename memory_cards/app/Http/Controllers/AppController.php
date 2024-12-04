<?php

namespace App\Http\Controllers;

use App\Helpers\AppLangHelper;
use App\Helpers\UiLangHelper as Lang;
use App\Traits\AppResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

abstract class AppController
{
    use AppResponse;

    protected string $app_lang_loc;
    protected int $app_lang_id;
    protected Model $model;
    protected FormRequest $request;
    public function __construct()
    {
        $this->app_lang_loc = AppLangHelper::getLocale();
        $this->app_lang_id  = AppLangHelper::getId();
    }

    public function create(): JsonResponse
    {
        return $this->saveModel($this->model);
    }

    public function update($id): JsonResponse
    {
        if (!$model = $this->getModelById($id)) {
            return $this->responseJson('Record not found', 404);
        }

        return $this->saveModel($model);
    }

    public function destroy(int $id): JsonResponse
    {
        if (!$model = $this->getModelById($id)) {
            return $this->responseJson('Record not found', 404);
        }
        $model->delete();

        return $this->responseJson('');
    }

    protected function handleExceptions(callable $callback)
    {
        try {
            return $callback();
        } catch (\Exception $e) {
            return $this->responseJson($e->getMessage(), 500);
        }
    }

    protected function getModelById(int $id): Model
    {
        $userId = auth()->id();
        return $this->model->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    protected function saveModel(Model $model): JsonResponse
    {
        return $this->handleExceptions(function () use ($model) {
            $data = $this->request->validated();
            $model->fill($data)->push();
            return $this->responseJson(Lang::get('saved'), 200, $model);
        });
    }

    public function set()
    {
        return $this->responseJson('', 200);
    }
}
