<?php

namespace App\Http\Controllers\almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


use App\Models\seguridad\Funcion;
use App\Models\almacen\UnidadMedida;

class UnidadesMedidaController extends Controller
{
    protected $modulo = "Almacen";
    protected $submodulo = "Unidades de Medida";
    protected $dir_modulo = "almacen";
    protected $dir_submodulo = "unidades_medida";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }

        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new UnidadMedida();
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
            $data["data"]      = UnidadMedida::find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = UnidadMedida::withTrashed()->get();
        return DataTables::of($objeto)
            ->addIndexColumn()
            ->addColumn("activo", function ($objeto) {
                return (is_null($objeto->deleted_at)) ? '<span class="dot-label bg-success" title="Activo">Activo</span>' : '<span class="dot-label bg-danger" title="Inactivo">Eliminado</span>';
            })
            ->rawColumns(["activo"])
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
            'abreviatura'     => 'required',
        ], [
            'descripcion.required' => 'Debes escribir el nombre de la unidad de medida',
            'abreviatura.required'  => 'Debes escribir la abreviatura de la unidad de medida',
        ]);

        return DB::transaction(function() use ($request){
            $obj = UnidadMedida::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new UnidadMedida();
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
        $obj = UnidadMedida::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            if($obj->productos->isNotEmpty()){
                throw ValidationException::withMessages(["referencias" => "Esta unidad de medida no se puede eliminar puesto que ya está relacionado con uno o más productos"]);

            }
            $obj->delete();
            return response()->json($obj);
        }
        $obj->restore();
        return response()->json();
    }
}