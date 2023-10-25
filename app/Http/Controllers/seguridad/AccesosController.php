<?php

namespace App\Http\Controllers\seguridad;
use App\Http\Controllers\Controller;

use Yajra\DataTables\DataTables;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

use App\Models\seguridad\Accesos;
use App\Models\seguridad\Funcion;
use App\Models\seguridad\Modulo;
use App\Models\seguridad\Submodulo;

class AccesosController extends Controller
{
    protected $modulo = "Seguridad";
    protected $submodulo = "Accesos";
    protected $dir_modulo = "seguridad";
    protected $dir_submodulo = "accesos";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }
        
        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new Accesos();
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
        $data["roles"]          = Role::get();
        $data["modulos"]        = Modulo::with('submodulos')->get();

        if($id != null){
            $data["data"]      = Accesos::find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function acceso(Request $request){
        return response()->json((new Modulo)->acceso_modulo($request->idrol));
    }

    public function store(Request $request)
    {
        return DB::transaction(function() use ($request){
            $array_mdpermisos = [];

            foreach(Submodulo::get() as $submodulo){
                foreach(Funcion::get() as $key => $funcion){
                    $validar = Permission::where('name', $funcion["funcion"].'-'.$submodulo["url"])
                    ->join('role_has_permissions as r_p', 'r_p.permission_id', '=', 'permissions.id')
                    ->where('r_p.role_id', $request->idrol)
                    ->count();

                    if($validar == 1)
                        $array_mdpermisos[$submodulo["id"]][$funcion["funcion"]] = ["funcion" => $funcion["funcion"]."-".$submodulo["url"]]; 
                }
            }

            if($request->filled("accesos_true") OR $request->filled("accesos_false")){
                $idsubmodulo_ant = 0;
                //QUITAR ACCESOS
                if($request->filled("accesos_false")){
                    foreach ($request->accesos_false as $key => $value) {
                        $ids = explode("-", $value["id"]);
                        $idsubmodulo = $ids[1];
                        $funcion     = $ids[2];
                        
                        Accesos::where('idsubmodulo', $idsubmodulo)->where('idrol', $request->idrol)->delete();
                        
                        if(array_key_exists($idsubmodulo, $array_mdpermisos)){
                            if($idsubmodulo != $idsubmodulo_ant){
                                unset($array_mdpermisos[$idsubmodulo]["store"]);
                            }
                            unset($array_mdpermisos[$idsubmodulo][$funcion]);
                        }
                    }
                }
                
                $idsubmodulo_ant = 0;
                if($request->filled("accesos_true")){
                    foreach ($request->accesos_true as $key => $value) {
                        $ids = explode("-", $value["id"]);
                        $idsubmodulo = $ids[1];
                        $funcion     = $ids[2];

                        $obj = Accesos::withTrashed()->where('idsubmodulo', $idsubmodulo)->where('idrol', $request->idrol)->first();
                        
                        if(is_null($obj))
                            $obj = new Accesos();
                        $obj->idsubmodulo = $idsubmodulo;
                        $obj->idrol       = $request->idrol;
                        $obj->deleted_at  = null;
                        if($obj->save()){
                            $submodulo = Submodulo::find($idsubmodulo);
                            
                            if($idsubmodulo != $idsubmodulo_ant){
                                $array_mdpermisos[$idsubmodulo]["store"] = ["funcion" => "store-".$submodulo["url"]];
                            }
                            
                            $array_mdpermisos[$idsubmodulo][$funcion] = ["funcion" => $funcion."-".$submodulo["url"]];
                            $idsubmodulo_ant = $idsubmodulo;
                        }
                    }
                }
                
                $array_funcion = [];
                if(count($array_mdpermisos) > 0){
                    foreach ($array_mdpermisos as $key => $value) {
                        $cont = 0;
                        foreach ($value as $funcion) {
                            $validar = Permission::where("name", $funcion["funcion"])->count();
                            if($validar == 0){
                                Permission::create(["name" => $funcion["funcion"]]);
                            }
                            array_push($array_funcion, $funcion["funcion"]);
                            $cont++;
                        }
                    }
                    $role = Role::find($request->idrol);
                    $role->syncPermissions($array_funcion);
                }
                return response()->json($request);
            }else{
                throw ValidationException::withMessages(["accesos" => "Lista de accesos vacia."]);
            }
        });
    }
}