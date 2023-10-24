<?php

namespace App\Http\Controllers\seguridad;
use App\Http\Controllers\Controller;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Funcion;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class EmpleadoController extends Controller
{
    protected $modulo = "Seguridad";
    protected $submodulo = "Empleados";
    protected $dir_modulo = "seguridad";
    protected $dir_submodulo = "empleados";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }

        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new Empleado();
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
            $data["data"]      = Empleado::find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = Empleado::withTrashed()->get();
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
            'dni' => ['required', 'numeric', 'digits:8', Rule::unique("{$this->driver_current}.{$this->model->getTableName()}", "dni")->ignore($request->id, "id")],
            'apellido_paterno' => 'required',
            'apellido_materno'     => 'required',
            'nombres'       => 'required',
            'email'       => ['required', 'email', Rule::unique("{$this->driver_current}.{$this->model->getTableName()}", "email")->ignore($request->id, "id")],
            'telefono'       => ['required', 'numeric', 'digits:9', Rule::unique("{$this->driver_current}.{$this->model->getTableName()}", "telefono")->ignore($request->id, "id") ],
        ], [
            'dni.required' => 'Debes escribir el DNI',
            'dni.numeric' => 'El DNI debe ser un número',
            'dni.digits' => 'El DNI debe tener 8 dígitos',
            'dni.unique' => 'Este DNI ya está registrado',
            'apellido_paterno.required' => 'Debes escribir el Apellido Paterno',
            'apellido_materno.required' => 'Debes escribir el Apellido Materno',
            'nombres.required'       => 'Debes escribir los nombres',
            'email.required'       => 'Debes escribir el email',
            'email.email'       => 'Debe tener el siguiente formato "ejemplo@gmail.com"',
            'telefono.required'       => 'Debes escribir el Teléfono',
            'telefono.numeric'       => 'El Teléfono debe ser un número',
            'telefono.digits'       => 'El Teléfono debe tener 9 dígitos',
        ]);

        return DB::transaction(function() use ($request){
            $obj = Empleado::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new Empleado();
            }
            $obj->fill($request->all());
            $obj->nombre_completo = $obj->nombres." ".$obj->apellido_paterno." ".$obj->apellido_materno;
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
        $obj = Empleado::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            $obj->delete();
            return response()->json($obj);
        }
        $obj->restore();
        return response()->json();
    }
}