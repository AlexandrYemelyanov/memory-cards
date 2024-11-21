<?php

namespace App\Http\Controllers;

use App\Http\Helpers\GroupsHelper;
use App\Http\Requests\GroupRequest;
use App\Models\Groups;
use App\Models\Langs;

class GroupsController extends AppController
{
    public function __construct(Groups $model, GroupRequest $request)
    {
        parent::__construct();
        $this->model = $model;
        $this->request = $request;
    }

    public function index(): mixed
    {
        $langs = Langs::getAll();
        $groups_info = GroupsHelper::getGroups();
        if (!$langs->count() || empty($groups_info)) {
            return redirect()->route('langs.index');
        }

        $data = [
            'langs' => $langs,
            'groups' => $groups_info['groups'],
            'app_lang_loc' => $this->app_lang_loc,
            'current_group' => $groups_info['curr_group_id'],
        ];

        return view('cards.groups', $data);
    }
}
