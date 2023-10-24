<?php

namespace App\Http\Controllers\seguridad;
use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use App\Models\Funcion;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;


class UsuarioController extends Controller
{
    protected $modulo = "Seguridad";
    protected $submodulo = "Usuarios";
    protected $dir_modulo = "seguridad";
    protected $dir_submodulo = "usuarios";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }

        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new User();
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
        $data["empleados"]      = Empleado::get();
        $data["roles"]          = Role::get();

        if($id != null){
            $data["data"]      = User::find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = User::with('empleado')->with('rol')->withTrashed()->get();
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
            'idempleado' => 'required',
            'idrol'     => 'required',
            'user'       => 'required',
            'password'       => [
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                ],
            'password_confirm'       => 'required',
        ], [
            'idempleado.required' => 'Debes seleccionar el empleado',
            'idrol.required'     => 'Debes seleccionar el rol',
            'user.required'       => 'Debes escribir el usuario',
            'user.unique'       => 'Este usuario ya está en uso',
            'password.required'       => 'Debes escribir la contraseña',
            'password.min'       => 'La contraseña debe terner mínimo 8 caracteres',
            'password_confirm.required' => 'Debes escribir la confirmación de la contraseña',
        ]);
    
        return DB::transaction(function() use ($request){
            if(User::where('idempleado', $request->idempleado)->where('id', '!=', $request->id)->first()){
                throw ValidationException::withMessages(["idempleado" => "Este empleado ya tiene un usuario asignado"]);
            }

            if(User::where('user', $request->user)->where('id', '!=', $request->id)->first()){
                throw ValidationException::withMessages(["user" => "Este ya se encuentra registrado"]);
            }

            if($request->password != $request->password_confirm){
                throw ValidationException::withMessages(["password_confirm" => "Las contraseñas deben coincidir"]);
            }

            $obj = User::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new User();
            }
            $obj->password = Hash::make($request->password);
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
        $obj = User::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            $obj->delete();
            return response()->json($obj);
        }
        $obj->restore();
        return response()->json();
    }
}