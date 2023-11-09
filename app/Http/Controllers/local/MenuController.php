<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

use App\Models\seguridad\Funcion;
use App\Models\local\Mesa;

class MenuController extends Controller
{
    protected $modulo = "Local";
    protected $submodulo = "Menu";
    protected $dir_modulo = "local";
    protected $dir_submodulo = "Menu";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }

        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new Mesa();
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
            $data["data"]      = Mesa::find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = Mesa::withTrashed()->get();
        return DataTables::of($objeto)
            ->addIndexColumn()
            ->addColumn("estado", function ($objeto) {
                if($objeto->estado == 2)
                    return "Ocupado";
                return "Libre";
            })
            ->addColumn("activo", function ($objeto) {
                return (is_null($objeto->deleted_at)) ? '<span class="dot-label bg-success" title="Activo">Activo</span>' : '<span class="dot-label bg-danger" title="Inactivo">Eliminado</span>';
            })
            ->rawColumns(["activo", "estado"])
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
            'cantidad' => 'required|integer',
        ], [
            'descripcion.required' => 'Debes escribir el nombre de la Mesa',
            'descripcion.unique' => 'Esta mesa ya está registrada',
            'cantidad.required' => 'Debes escribir la cantidad de sitios',
            'cantidad.integer' => 'La cantidad de sitios debe ser un número',
        ]);

        return DB::transaction(function() use ($request){
            $obj = Mesa::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new Mesa();
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
        $obj = Mesa::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            $obj->delete();
            return response()->json($obj);
        }
        $obj->restore();
        return response()->json();
    }
}