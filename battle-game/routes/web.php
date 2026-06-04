<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BattleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/battle/simulate', [BattleController::class, 'simulate']);
