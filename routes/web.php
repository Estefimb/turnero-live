<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurnoController;



Route::get('/', function () {
    return view('welcome');
});
Route::get('/', fn() => redirect()->route('emisor'));

Route::get('/emisor',  [TurnoController::class, 'emisor'])->name('emisor');
Route::post('/emitir', [TurnoController::class, 'emitir'])->name('emitir');

Route::get('/receptor', [TurnoController::class, 'receptor'])->name('receptor');
