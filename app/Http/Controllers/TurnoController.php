<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TurnoActualizado;

class TurnoController extends Controller
{
    public function emisor()
    {
        return view('turnos.emisor');
    }

    public function receptor()
    {
        return view('turnos.receptor');
    }

    public function emitir(Request $request)
    {
        $data = $request->validate([
            'codigo' => ['required', 'string', 'max:20'],
            'caja'   => ['required', 'string', 'max:50'],
            'mensaje' => ['nullable', 'string', 'max:200'],
        ]);

        event(new TurnoActualizado(
            $data['codigo'],
            $data['caja'],
            $data['mensaje'] ?? null
        ));

        return back()->with('ok', 'Turno emitido correctamente.');
    }
}
