<?php

use App\Http\Controllers\GroupsController;
use App\Http\Controllers\LangsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserLangController;

use App\Http\Helpers\GroupsHelper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;


// Auth
Route::middleware('auth')->group(function () {
    Route::get('/', [CardController::class, 'index']);

    Route::prefix('/groups')->group(function () {
        Route::get('', [GroupsController::class, 'index'])->name('group.index');
        Route::post('/new', [GroupsController::class, 'create']);
        Route::post('/save/{group_id}', [GroupsController::class, 'update'])->where(['card_id' => '[0-9]+']);
        Route::post('/set', [GroupsController::class, 'set']);
        Route::get('/remove/{group_id}', [GroupsController::class, 'destroy'])->where(['card_id' => '[0-9]+']);
        Route::post('/move', [CardController::class, 'move']);
    });

    Route::prefix('/langs')->group(function () {
        Route::get('', [LangsController::class, 'index'])->name('langs.index');
        Route::post('/new', [LangsController::class, 'create']);
        Route::post('/save/{lang_id}', [LangsController::class, 'update'])->where(['lang_id' => '[0-9]+']);
        Route::post('/set', [LangsController::class, 'set']);
        Route::get('/remove/{lang_id}', [LangsController::class, 'destroy'])->where(['lang_id' => '[0-9]+']);

    });

    Route::prefix('/user')->group(function () {
        Route::post('/lang/save', [UserLangController::class, 'updateUserLang']);
    });

    Route::prefix('/cards')->group(function () {
        Route::get('/add', function () {
            $groups = GroupsHelper::getGroups();
            if (!count($groups['groups'])) {
                return redirect()->route('group.index');
            }
            return view('cards.create', $groups);
        })->name('card.add');
        Route::post('/add', [CardController::class, 'create']);

        Route::get('/import', function () {
            return view('cards.import',  GroupsHelper::getGroups());
        });
        Route::post('/import/csv', [CardController::class, 'importCsv']);
        Route::post('/translate', [CardController::class, 'translate']);
        Route::post('/update/{card_id}', [CardController::class, 'update'])->where(['card_id' => '[0-9]+']);
        Route::get('/remove/{card_id}', [CardController::class, 'destroy'])->where(['card_id' => '[0-9]+']);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
