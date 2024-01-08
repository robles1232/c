<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

use App\Models\seguridad\Funcion;
use App\Models\local\SeccionCarta;

class SeccionCartaController extends Controller
{
    protected $modulo = "Local";
    protected $submodulo = "Sección de Carta";
    protected $dir_modulo = "local";
    protected $dir_submodulo = "seccion_carta";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }

        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new SeccionCarta();
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
            $data["data"]      = SeccionCarta::find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = SeccionCarta::withTrashed();
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
            'descripcion' => ['required', Rule::unique("{$this->driver_current}.{$this->model->getTableName()}", "descripcion")->ignore($request->id, "id")],
            'orden' => 'required|integer',
        ], [
            'descripcion.required' => 'Debes escribir el nombre de la Sección de la Carta',
            'descripcion.unique' => 'Esta sección ya se encuentra registrada',
            'orden.required' => 'Debes escribir el orden de la sección',
            'orden.integer' => 'El orden debe ser un número',
        ]);

        return DB::transaction(function() use ($request){
            $obj = SeccionCarta::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new SeccionCarta();
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
        $obj = SeccionCarta::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            $obj->delete();
            return response()->json($obj);
        }
        $obj->restore();
        return response()->json();
    }

    public function buscar($search){
        $search           = str_replace(' ', '', urldecode($search));;

        $objeto     = SeccionCarta::whereRaw("descripcion like (?)", ["%{$search}%"]);

        $datos["search"]  = $objeto->take(10)->get();
        return $datos;
    }
}