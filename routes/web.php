<?php

use App\Http\Controllers\CullsController;
use App\Http\Controllers\ScoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/culls', [CullsController::class,'getCulls'])->name('culls');
Route::post('/storescore', [CullsController::class, 'createScore'])->name('storescore');
Route::get('/scores', [CullsController::class, 'getScores'])->name('scores.display');
Route::get('/', [CullsController::class, 'home']);
