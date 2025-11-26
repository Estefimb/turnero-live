<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TurnoActualizado;
use App\Events\TurnoCreado;
use App\Events\TurnoFinalizado;
use App\Models\Turno;
use App\Mail\SatisfactionMail;

class TurnoController extends Controller
{
    public function emisor()
    {
        return view('turnos.operador');
    }

    public function receptor()
    {
        return view('turnos.receptor');
    }

    

    //Crear turno
 public function store(Request $request)// Crear tunno
{
    $data = $request->validate([
 'nombre' => 'required|string',
 'dni' => 'required|string',
 'tipo' => 'required|in:caja,asesoria',
 'corresponde' => 'nullable|string',
 'email' => 'nullable|email',
 ]);

 $codigo = \App\Models\Turno::generateCodigo($data['tipo']); // <--- POSIBLE PUNTO DE FALLO

 $turno = \App\Models\Turno::create(array_merge($data, ['codigo' => $codigo])); // <--- POSIBLE PUNTO DE FALLO

event(new \App\Events\TurnoCreado($turno));

 return response()->json(['message' => 'Turno creado y evento emitido'], 200);
}

    public function siguiente(Request $request) // Siguiente turno
    {
        // opcional: $request->validate(['tipo'=>'nullable|in:caja,asesoria']);
        $turno = \App\Models\Turno::where('estado','pendiente')->orderBy('id')->first();
        if (! $turno) return response()->json(['message'=>'No hay turnos pendientes'], 404);

        $turno->estado = 'en_curso';
        $turno->operador_id = $request->operador_id ?? null;
        if ($request->corresponde) $turno->corresponde = $request->corresponde;
        $turno->llamado_en = now();
        $turno->save();

        event(new \App\Events\TurnoActualizado($turno));
        return response()->json($turno);
    }

    public function finalizar(Request $request, \App\Models\Turno $turno) // Finalizar turno
    {
        $request->validate(['email'=>'nullable|email']);

        $turno->estado = 'finalizado';
        $turno->save();

        broadcast(new \App\Events\TurnoFinalizado($turno));



        return response()->json([
        'ok' => true,
        'turno' => $turno
        ]);
        }


    public function indexOperator()
    {
    // Obtiene todos los turnos agrupados por estado
        $pendientes = \App\Models\Turno::where('estado', 'pendiente')->orderBy('created_at')->get();
        $enCurso = \App\Models\Turno::where('estado', 'en_curso')->orderBy('updated_at')->get();
        $finalizados = \App\Models\Turno::where('estado', 'finalizado')->orderBy('updated_at', 'desc')->get();

        return view('turnos.operador', compact('pendientes', 'enCurso', 'finalizados'));
    }

    public function indexPublic()
    {
    // Obtiene los turnos en curso / pendientes según tu lógica
        $turnos = Turno::orderBy('created_at', 'asc')->get();

        return view('turnos.receptor', compact('turnos'));
    }

}