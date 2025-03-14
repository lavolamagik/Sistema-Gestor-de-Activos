<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoActivo;
use App\Models\Activo;
use App\Models\CaracteristicaAdicional;
use Vinkla\Hashids\Facades\Hashids;


class GestionarTipoActivoController extends Controller
{
    public function index()
    {
        // Obtener todos los tipos de activos desde la base de dat  os
        $tiposActivo = TipoActivo::all();

        foreach ($tiposActivo as $tipo) {
            foreach ($tipo->caracteristicasAdicionales as $caracteristica) {
                $caracteristica->hashed_id = $caracteristica->getHashedIdAttribute(); // Forzar su inclusión
            }
        }

        // Obtener todos los tipos de activos con sus características adicionales
        $tiposActivo = TipoActivo::with('caracteristicasAdicionales')->get();

        // Pasar los datos a la vista
        return view('gestionarTipoActivo', compact('tiposActivo'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Verificar si el nombre ya existe
        if (TipoActivo::where('nombre', strtoupper($request->nombre))->exists()) {
            return redirect()->route('tipos-activo.index')->with('error', 'Tipo de activo ya se encuentra registrado.');
        }

        // Crear un nuevo tipo de activo
        $tipoActivo = TipoActivo::create([
            'nombre' => strtoupper($request->nombre),
        ]);

        $caracteristicasAdicionales = $request->caracteristicasAdicionales;

        if($caracteristicasAdicionales == null){
            return redirect()->route('tipos-activo.index')->with('success', 'Tipo de activo registrado correctamente.');
        }

        //Agregar las caracteristicas adicionales
        foreach ($caracteristicasAdicionales as $caracteristica) {
            CaracteristicaAdicional::create([
                'tipo_activo_id' => $tipoActivo->id,
                'nombre_caracteristica' => strtoupper($caracteristica),
            ]);
        }
        // Redirigir con un mensaje de éxito
        return redirect()->route('tipos-activo.index')->with('success', 'Tipo de activo registrado correctamente.');
    }

    public function destroy($hashed_id)
    {
        // Desencriptar el ID
        $decoded = Hashids::decode($hashed_id);

        if (empty($decoded)) {
            return redirect()->route('tipos-activo.index')->with('error', 'ID inválido.');
        }

        $id = $decoded[0];

        // Buscar el tipo de activo por ID
        $tipoActivo = TipoActivo::findOrFail($id);

        // Verificar si hay activos asociados a este tipo
        $activosAsociados = Activo::where('tipo_de_activo', $id)->exists();

        if ($activosAsociados) {
            // Si hay activos asociados, no se puede eliminar
            return redirect()->route('tipos-activo.index')->with('error', 'No se puede eliminar el tipo de activo porque hay activos asociados.');
        }

        // Si no hay activos asociados, proceder a eliminar
        $tipoActivo->delete();

        // Eliminar las caracteristicas adicionales asociadas
        $tipoActivo->caracteristicasAdicionales()->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('tipos-activo.index')->with('success', 'Tipo de activo eliminado correctamente.');
    }



    public function nuevasCaracteristicas(Request $request)
    {
        $caracteristicasAdicionales = $request->caracteristicasAdicionales;

        if($caracteristicasAdicionales == null){
            return redirect()->route('tipos-activo.index')->with('error', 'No se han ingresado características adicionales.');
        }

        //comprobar que no se agregue caracteristica repetida para el mismo tipo de activo
        foreach ($caracteristicasAdicionales as $caracteristica) {
            if (CaracteristicaAdicional::where('tipo_activo_id', $request->tipoActivoId)->where('nombre_caracteristica', strtoupper($caracteristica))->exists()) {
                return redirect()->route('tipos-activo.index')->with('error', 'Característica adicional ya se encuentra registrada.');
            }
        }

        if($caracteristicasAdicionales == null){
            return redirect()->route('tipos-activo.index');
        }

        //Agregar las caracteristicas adicionales
        foreach ($caracteristicasAdicionales as $caracteristica) {
            CaracteristicaAdicional::create(attributes: [
                'tipo_activo_id' => $request->tipoActivoId,
                'nombre_caracteristica' => strtoupper($caracteristica),
            ]);
        }
        return redirect()->route('tipos-activo.index')->with('success', value: 'Características agregadas correctamente.');

    }

    public function destroyCaracteristicaAdicional($hashed_id)
    {
        // Desencriptar el ID
        $decoded = Hashids::decode($hashed_id);

        if (empty($decoded)) {
            return redirect()->route('tipos-activo.index')->with('error', 'ID inválido.');
        }

        $id = $decoded[0];


        // Buscar la caracteristica adicional
        $caracteristicaAdicional = CaracteristicaAdicional::findOrFail($id);

        // Verificar si hay valores adicionales asociados
        $valoresAdicionales = $caracteristicaAdicional->valoresAdicionales()->count();

        if ($valoresAdicionales > 0) {
            // Redirigir con un mensaje de error
            return redirect()->route('tipos-activo.index')->with('error', 'No se puede eliminar la característica adicional porque tiene valores asociados.');
        }

        // Si no hay valores adicionales, eliminar la caracteristica adicional
        $caracteristicaAdicional->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('tipos-activo.index')->with('success', 'Característica adicional eliminada correctamente.');
    }


}
