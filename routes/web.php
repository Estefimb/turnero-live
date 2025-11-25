<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurnoController;



Route::get('/', function () {
    return view('welcome');
});
Route::get('/', fn() => redirect()->route('turnos.operator'));

//Route::get('/emisor',  [TurnoController::class, 'emisor'])->name('emisor');
//Route::post('/emitir', [TurnoController::class, 'emitir'])->name('emitir');

//Route::get('/receptor', [TurnoController::class, 'receptor'])->name('receptor');

Route::get('/operador', [TurnoController::class,'indexOperator'])->name('turnos.operator');
Route::get('/receptor', [TurnoController::class,'indexPublic'])->name('turnos.receptor');

Route::post('/operador', [TurnoController::class,'store'])->name('turnos.store');
Route::post('/turnos/siguiente', [TurnoController::class,'siguiente'])->name('turnos.siguiente');
Route::post('/turnos/{turno}/finalizar', [TurnoController::class,'finalizar'])->name('turnos.finalizar');

// En routes/web.php o routes/api.php
Route::get('/turnos/{turno}/survey', function (Turno $turno) {
    // Aquí iría tu lógica real de mostrar la encuesta.
    return "<h1>Encuesta para el turno {$turno->codigo}</h1><p>Gracias por responder.</p>";
})->name('turnos.survey.show');

//Con los archivos proporcionados en este y los pasos anteriores, el sistema de mailing ya está completamente integrado.