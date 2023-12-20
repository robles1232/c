<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

use App\Models\seguridad\Funcion;
use App\Models\local\Plato;
use App\Models\local\PlatoDetalle;

class PlatoController extends Controller
{
    protected $modulo = "Local";
    protected $submodulo = "Platos";
    protected $dir_modulo = "local";
    protected $dir_submodulo = "platos";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }

        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new Plato();
        $this->table =  $this->model->getTableName();
    }

    public function form($id = null){
        $data["modulo"]         = $this->modulo;
        $data["submodulo"]      = $this->submodulo;
        $data["table"]          = $this->table;
        $data["dir_modulo"]     = $this->dir_modulo;
        $data["dir_submodulo"]  = $this->dir_submodulo;
        $data["path_controller"]= $this->path_controller;
        $data["prefix"]         = "";
        $data["data"]           = [];

        if($id != null){
            $data["data"]      = Plato::with('detalle.producto')->find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = Plato::withTrashed()->get();
        return DataTables::of($objeto)
            ->addIndexColumn()
            ->addColumn("precio_venta", function ($objeto) {
                return "S/.".$objeto->precio_venta;
            })
            ->addColumn("activo", function ($objeto) {
                return (is_null($objeto->deleted_at)) ? '<span class="dot-label bg-success" title="Activo">Activo</span>' : '<span class="dot-label bg-danger" title="Inactivo">Eliminado</span>';
            })
            ->rawColumns(["activo", "precio_venta"])
            ->make(true);
    }

    public function create()
    {
        return view($this->dir_modulo.'/'.$this->dir_submodulo."/form", $this->form());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => ['required', Rule::unique("{$this->driver_current}.{$this->model->getTableName()}", "nombre")->ignore($request->id, "id")],
            'descripcion' => 'required',
            'precio_venta' => 'required|numeric',
        ], [
            'nombre.required' => 'Debes escribir el nombre del Plato',
            'nombre.unique' => 'Este Plato ya está registrado',
            'descripcion.required' => 'Debes indicar la descripción del Plato',
            'precio_venta.required' => 'Debes indicar el precio de venta',
            'precio_venta.numeric' => 'El precio de venta debe ser un número',
        ]);

        return DB::transaction(function() use ($request){
            if(empty($request->productos)){
                throw ValidationException::withMessages(["productos" => "Debes enviar los productos que se usan para preparar el plato"]);
            }
            
            $obj = Plato::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new Plato();
            }

            $obj->fill($request->all());
            $obj->save();

            foreach ($request->productos as $key => $value) {
                if($key == 0)
                    PlatoDetalle::where('idplato', $obj->id)->delete();

                $obj2 = PlatoDetalle::withTrashed()->find($value["id"]);
                if(empty($obj2)){
                    $obj2 = new PlatoDetalle();
                }
    
                $obj2->fill($value);
                $obj2->idplato = $obj->id;
                $obj2->deleted_at = null;
                $obj2->save();
            }
            
            return response()->json($obj);
        });
    }

    public function edit($id)
    {
        return view($this->dir_modulo.'/'.$this->dir_submodulo."/form", $this->form($id));
    }

    public function destroy(Request $request)
    {   
        $obj = Plato::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            $obj->delete();
            return response()->json($obj);
        }
        $obj->restore();
        return response()->json();
    }

    public function buscar_carta($search){
        $search           = str_replace(' ', '', urldecode($search));;

        $objeto     = Plato::whereRaw("nombre like (?)", ["%{$search}%"]);
        $objeto->select("id", "nombre as descripcion", "precio_venta");
        $datos["search"]  = $objeto->take(10)->get();
        return $datos;
    }
}