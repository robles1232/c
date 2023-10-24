<?php

namespace App\Http\Controllers\seguridad;
use App\Http\Controllers\Controller;
use App\Models\Funcion;
use App\Models\FuncionSubmodulo;
use App\Models\Modulo;
use App\Models\Submodulo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;


class SubmoduloController extends Controller
{
    protected $modulo = "Seguridad";
    protected $submodulo = "Submodulos";
    protected $dir_modulo = "seguridad";
    protected $dir_submodulo = "submodulos";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }
        
        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new Submodulo();
        $this->table = $this->model->getTableName();
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
        $data["modulos"]        = Modulo::get();
        $data["funciones"]      = Funcion::get();

        if($id != null){
            $data["data"]      = Submodulo::with('funciones.funcion')->find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = Submodulo::with('modulo')->withTrashed()->get();
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
            'idmodulo' => 'required',
            'descripcion' => 'required',
            'abreviatura'     => 'required',
            'url'       => 'required',
            'icono'       => 'required',
            'orden'       => 'required|integer',
        ], [
            'idmodulo.required' => 'Debes seleccionar el módulo',
            'descripcion.required' => 'Debes escribir el nombre del submódulo',
            'abreviatura.required'     => 'Debes escribir la abreviatura',
            'url.required'       => 'Debes escribir la url',
            'icono.required'       => 'Debes escribir el ícono',
            'orden.required'       => 'Debes escribir el orden',
            'orden.integer'        => 'Debe ser un número entero',
        ]);

        return DB::transaction(function() use ($request){
            $obj = Submodulo::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new Submodulo();
            }
            $obj->fill($request->all());
            $obj->save();
            
            if(empty($request->funciones)){
                throw ValidationException::withMessages(["funciones" => "Debes seleccionar las funciones del submódulo"]);
            }

            foreach ($request->funciones as $key => $value) {
                if($key == 0)
                    FuncionSubmodulo::where('idsubmodulo', $obj->id)->delete();
                
                $obj2 = FuncionSubmodulo::withTrashed()->find($value["id"]);
                if(empty($obj2)){
                    $obj2 = new FuncionSubmodulo();
                }
    
                $obj2->fill($value);
                $obj2->idsubmodulo = $obj->id;
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
        $obj = Submodulo::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            $obj->delete();
            return response()->json($obj);
        }
        $obj->restore();
        return response()->json();
    }
}
