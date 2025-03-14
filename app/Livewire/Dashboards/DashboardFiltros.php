<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\Activo;
use App\Models\Persona;
use App\Models\Ubicacion;
use App\Models\Estado;
use App\Models\TipoActivo;

class DashboardFiltros extends Component
{
    protected $listeners = ['actualizarAtributo', 'cambiarDashboard'];
    public $cantidadActivos;
    public $filtro;
    public $conteoValores;
    public $atributos;

    public $activosEnServicio;
    public $activosFueraDeServicio;
    public $vista;
    public $valor;
    public $nombreVista;

    public function mount($vista, $valor = null)
    {
        $this->vista = $vista;
        $this->valor = $valor;
        if($vista=="UBICACION"){
            $this->nombreVista = Ubicacion::find($valor)->sitio;
            $this->filtro = "tipo_de_activo";
        }
        else if($vista=="TIPO_DE_ACTIVO"){
            $this->nombreVista = TipoActivo::find($valor)->nombre;
            $this->filtro = "ubicacion";
        }
        else{
            $this->nombreVista = "General";
            $this->filtro = "tipo_de_activo";
        }

        $this->atributos = $this->obtenerAtributos();
        $this->actualizarAtributo($this->filtro);
        $this->calcularCantidadActivos();

    }
    public function render()
    {
        $cantidadPersonas = Persona::count();
        $cantidadUbicaciones = Ubicacion::count();

        $ubicaciones = Ubicacion::all();
        $cantidadPorEstados = $this->calcularActivosPorEstados();
        $tiposDeActivo = TipoActivo::all();
        $opcionesDashboard = $this->obtenerOpcionesDashboard();
        $this->calcularCantidadActivos();


        // Pasar el usuario a la vista
        return view('livewire.dashboards.dashboard-filtros',compact(
        'cantidadPersonas','cantidadUbicaciones',
        'ubicaciones', 'cantidadPorEstados','tiposDeActivo','opcionesDashboard'));
    }

    public function obtenerOpcionesDashboard(){
        if($this->vista=="UBICACION"){
            $ubicaciones = Ubicacion::all();
            $opciones = [];
            foreach($ubicaciones as $ubicacion){
                $opciones[$ubicacion->id] = $ubicacion->sitio;
            }
        }
        else if($this->vista=="TIPO_DE_ACTIVO"){
            $tiposDeActivo = TipoActivo::all();
            $opciones = [];
            foreach($tiposDeActivo as $tipo){
                $opciones[$tipo->id] = $tipo->nombre;
            }
        }
        else{
            $opciones = [];
        }
        return $opciones;

    }

    public function actualizarAtributo($atributo)
    {
        if (!in_array($atributo, $this->atributos)) {
            $this->conteoValores = [];
            $this->filtro = null;
            $this->dispatch('$refresh');
            return;
        }

        $valores = $this->obtenerValoresPorAtributo($atributo);
        $this->conteoValores = array_count_values($valores);

        $this->conteoValores = $this->mapearNombres($atributo, $this->conteoValores);
        $this->filtro = $atributo;

        $this->dispatch('$refresh');
    }

    /**
     * Obtiene los valores de un atributo en función de la vista actual.
     */
    private function obtenerValoresPorAtributo($atributo)
    {
        $query = Activo::query();

        if ($this->vista === "UBICACION") {
            $query->where('ubicacion', $this->valor);
        } elseif ($this->vista === "TIPO_DE_ACTIVO") {
            $query->where('tipo_de_activo', $this->valor);
        }

        return $query->pluck($atributo)->toArray();
    }

    /**
     * Mapea los valores de un atributo con su respectivo nombre.
     */
    private function mapearNombres($atributo, $conteoValores)
    {
        $modelos = [
            "estado" => Estado::class,
            "ubicacion" => Ubicacion::class,
            "tipo_de_activo" => TipoActivo::class,
        ];

        if (isset($modelos[$atributo])) {
            foreach ($conteoValores as $key => $value) {
                $modelo = optional($modelos[$atributo]::find($key));
                $conteoValores[$key] = [
                    'nombre' => $modelo->nombre ?? $modelo->sitio ?? $modelo->nombre_estado ?? $key,
                    'cantidad' => $value
                ];
            }
        } else {
            foreach ($conteoValores as $key => $value) {
                $conteoValores[$key] = ['nombre' => $key, 'cantidad' => $value];
            }
        }

        return $conteoValores;
    }


    public function obtenerAtributos(){
        $atributos = (new Activo())->getFillable();
        $atributos = array_diff($atributos, ['id', 'nro_serie',
        'responsable_de_activo','precio','justificacion_doble_activo','created_at', 'updated_at']);
        if ($this->vista=="UBICACION"){
            $atributos = array_diff($atributos, ['ubicacion']);
        }
        else if ($this->vista=="TIPO_DE_ACTIVO"){
            $atributos = array_diff($atributos, ['tipo_de_activo']);
        }
        return $atributos;
    }

    public function calcularActivosPorEstados(){
        $estados = [];
        $estadosDisponibles = Estado::all();
        foreach ($estadosDisponibles as $estado) {
            if($this->vista == "GENERAL"){
                $estados[$estado->nombre_estado] = [
                'cantidad' => Activo::where('estado', $estado->id)->count(),
                'descripcion' => $estado->descripcion
                ];
            }
            else if ($this->vista == "UBICACION"){
                $estados[$estado->nombre_estado] = [
                'cantidad' => Activo::where('estado', $estado->id)->where('ubicacion', $this->valor)->count(),
                'descripcion' => $estado->descripcion
                ];
            }
            else if ($this->vista == "TIPO_DE_ACTIVO"){
                $estados[$estado->nombre_estado] = [
                'cantidad' => Activo::where('estado', $estado->id)->where('tipo_de_activo', $this->valor)->count(),
                'descripcion' => $estado->descripcion
                ];
            }
        }
        return $estados;
    }

    public function calcularCantidadActivos(){
        if($this->vista=="GENERAL"){
            $this->cantidadActivos = Activo::count();
            $this->activosEnServicio = Activo::whereIn('estado', [1, 2, 3, 4, 7])->count();
            $this->activosFueraDeServicio = Activo::whereIn('estado', [5, 6, 8, 9, 10])->count();
        }
        else if ($this->vista=="UBICACION"){
            $this->cantidadActivos = Activo::where('ubicacion', $this->valor)->count();
            $this->activosEnServicio = Activo::where('ubicacion', $this->valor)->whereIn('estado', [1, 2, 3, 4, 7])->count();
            $this->activosFueraDeServicio = Activo::where('ubicacion', $this->valor)->whereIn('estado', [5, 6, 8, 9, 10])->count();
        }
        else if ($this->vista=="TIPO_DE_ACTIVO"){
            $this->cantidadActivos = Activo::where('tipo_de_activo', $this->valor)->count();
            $this->activosEnServicio = Activo::where('tipo_de_activo', $this->valor)->whereIn('estado', [1, 2, 3, 4, 7])->count();
            $this->activosFueraDeServicio = Activo::where('tipo_de_activo', $this->valor)->whereIn('estado', [5, 6, 8, 9, 10])->count();
        }

    }

    public function cambiarDashboard($vista, $tipoDeActivo_id = null){

        $this->vista = $vista;
        $this->valor = $tipoDeActivo_id;
        if($this->vista=="UBICACION"){
            $this->nombreVista = Ubicacion::find($this->valor)->sitio;
            $this->filtro = "tipo_de_activo";
        }
        else if($this->vista=="TIPO_DE_ACTIVO"){
            $this->nombreVista = TipoActivo::find($this->valor)->nombre;
            $this->filtro = "ubicacion";
        }
        else{
            $this->nombreVista = "General";
            $this->filtro = "tipo_de_activo";
            $this->dispatch('$refresh');
            $this->dispatch('actualizarDashboard', [
                'vista' => $this->vista,
                'opcionesDashboard' => $this->obtenerOpcionesDashboard(),
                'valor' => $this->valor,
            ]);
        }

        $this->atributos = $this->obtenerAtributos();
        $this->actualizarAtributo($this->filtro);
        $this->calcularCantidadActivos();
        $this->dispatch('$refresh');
        $this->dispatch('actualizarDashboard', [
            'vista' => $this->vista,
            'opcionesDashboard' => $this->obtenerOpcionesDashboard(),
            'valor' => $this->valor,
        ]);
    }

}
