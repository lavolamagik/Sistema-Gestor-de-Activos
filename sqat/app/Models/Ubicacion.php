<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    // Especificar el nombre de la tabla si no sigue la convención plural
    protected $table = 'ubicaciones';

    // Definir los campos asignables masivamente
    protected $fillable = [
        'sitio',
        'soporteTI',
    ];

    // Si no estás utilizando timestamps, puedes desactivarlos
    // protected $timestamps = false;
}
