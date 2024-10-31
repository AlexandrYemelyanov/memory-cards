<?php

use App\Http\Controllers\GroupsController;
use App\Http\Controllers\ProfileController;
use App\Models\Groups;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;

// Auth
Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [CardController::class, 'index']);

    Route::prefix('/groups')->group(function () {
        Route::get('', [GroupsController::class, 'index']);
        Route::post('/new', [GroupsController::class, 'create']);
        Route::post('/save', [GroupsController::class, 'update']);
        Route::get('/remove/{group_id}', [GroupsController::class, 'destroy'])->where(['card_id' => '[0-9]+']);
    });

    Route::prefix('/cards')->group(function () {
        Route::get('/add', function () {
            return view('cards.create', ['groups' => Groups::getAll()]);
        })->name('card.add');
        Route::post('/add', [CardController::class, 'create']);

        Route::get('/import', function () {
            return view('cards.import');
        });
        Route::post('/import', [CardController::class, 'importCsv']);

        Route::post('/update', [CardController::class, 'update']);
        Route::get('/remove/{card_id}', [CardController::class, 'destroy'])->where(['card_id' => '[0-9]+']);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
