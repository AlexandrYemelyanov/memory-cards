<?php

namespace App\Http\Controllers;

use App\Http\Requests\LangsRequest;
use App\Models\Langs;
use App\Services\Contracts\TranslatorInterface;
use App\Services\TranslatorFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
    public function index(): View
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
