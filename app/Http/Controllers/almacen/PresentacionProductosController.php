<?php

namespace App\Http\Controllers\almacen;

use App\Http\Controllers\Controller;
use App\Models\almacen\PresentacionesProducto;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


use App\Models\seguridad\Funcion;
use App\Models\almacen\PresentacionProducto;
use App\Models\almacen\UnidadMedida;

class PresentacionProductosController extends Controller
{
    protected $modulo = "Almacen";
    protected $submodulo = "Presentación de Productos";
    protected $dir_modulo = "almacen";
    protected $dir_submodulo = "presentacion_productos";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }

        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new PresentacionProducto();
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
        $data["unidad_medida"]  = UnidadMedida::get();
        $data["data"]           = [];

        if($id != null){
            $data["data"]      = PresentacionProducto::find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = PresentacionProducto::with('unidad_medida')->withTrashed();
        return DataTables::of($objeto)
            ->addIndexColumn()
            ->addColumn("cantidad", function ($objeto) {
                return $objeto->cantidad." ".$objeto->unidad_medida->abreviatura;
            })
            ->addColumn("activo", function ($objeto) {
                return (is_null($objeto->deleted_at)) ? '<span class="dot-label bg-success" title="Activo">Activo</span>' : '<span class="dot-label bg-danger" title="Inactivo">Eliminado</span>';
            })
            ->rawColumns(["cantidad", "activo"])
            ->make(true);
    }

    public function create()
    {
        return view($this->dir_modulo.'/'.$this->dir_submodulo."/form", $this->form());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'descripcion' => 'required',
            'cantidad' => 'required|numeric',
            'idunidad_medida' => 'required',
        ], [
            'descripcion.required' => 'Debes escribir la Presentación del Producto',
            'cantidad.required' => 'Debes escribir la cantidad',
            'cantidad.numeric' => 'La cantidad debe ser un número',
            'idunidad_medida.required' => 'Selecciona la unidad de medida'
        ]);

        return DB::transaction(function() use ($request){
            $obj = PresentacionProducto::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new PresentacionProducto();
            }

            $obj->fill($request->all());
            $obj->save();
    

            return response()->json($obj);
        });
    }

    public function edit($id)
    {
        return view($this->dir_modulo.'/'.$this->dir_submodulo."/form", $this->form($id));
    }

    public function destroy(Request $request)
    {   
        $obj = PresentacionProducto::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            $obj->delete();
            return response()->json($obj);
        }
        $obj->restore();
        return response()->json();
    }

    public function getPresentacion_producto($idunidad_medida){
        $data = PresentacionProducto::where('idunidad_medida', $idunidad_medida)->get();

        return response()->json($data);
    }
}