<?php

namespace App\Http\Controllers;

use App\Http\Requests\LangsRequest;
use App\Models\Langs;
use App\Models\MemoryCard;
use App\Models\Groups;
use App\Models\User;
use App\Services\Contracts\TranslatorInterface;
use App\Services\TranslatorFactory;
use Illuminate\Http\Request;
use App\Http\Helpers\UiLangHelper as Lang;
use Illuminate\Support\Facades\Auth;

class LangsController extends AppController
{
    protected TranslatorInterface $translator;

    public function __construct(Langs $model, LangsRequest $request, TranslatorFactory $translatorFactory)
    {
        parent::__construct();
        $this->translator = $translatorFactory->make();
        $this->model = $model;
        $this->request = $request;
    }
    public function index(): mixed
    {
        $data = [
            'langs' => Langs::getAll()->toArray(),
            'user_lang' => Auth::user()->loc,
            'access_langs' => $this->translator->getAccessLangs(),
            'app_lang_loc' => $this->app_lang_loc,
        ];

        return view('cards.langs', $data);
    }
}
