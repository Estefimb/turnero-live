<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Turno extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'nombre',
        'dni',
        'tipo',
        'corresponde',
        'estado',
        'email',
        'operador_id',
        'llamado_en'
    ];

    public static function generateCodigo(string $tipo): string
    {
        $prefix = $tipo === 'caja' ? 'C' : 'A';
        $last = self::where('tipo', $tipo)->latest('id')->first();
        $num = $last ? intval(preg_replace('/\D/','',$last->codigo)) + 1 : 1;
        return sprintf('%s%02d', $prefix, $num);
    }
}
