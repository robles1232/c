<?php

namespace App\Http\Controllers\seguridad;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

use App\Models\seguridad\Funcion;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
    protected $modulo = "Seguridad";
    protected $submodulo = "Roles";
    protected $dir_modulo = "seguridad";
    protected $dir_submodulo = "roles";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }
        
        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new Role();
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
            $data["data"]      = Role::find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = Role::withTrashed()->get();
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
            'name' => 'required',
        ], [
            'name.required' => 'Escribe el nombre del rol',
        ]);

        return DB::transaction(function() use ($request){
            $obj = Role::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new Role();
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
        $obj = Role::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            $obj->delete();
            return response()->json($obj);
        }
        $obj->restore();
        return response()->json();
    }
}