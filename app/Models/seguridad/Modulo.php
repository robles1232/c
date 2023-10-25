<?php

namespace App\Models\seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class Modulo extends Model
{
    use SoftDeletes;

    protected $table        = "modulos";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'abreviatura',
        'icono',
        'orden',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function submodulos(){
        return $this->hasMany(Submodulo::class, 'idmodulo');
    }

    public function acceso_modulo($idrol){
        $query = static::with('submodulos')->orderBy('orden')->get();

        $data = [];
        foreach ($query as $item) {
            $value                    = [];
            $value['id']              = "p-".$item->id;
            $value['text']            = $item->descripcion;
            $value['icon']            = $item->icono;
            $value['state']['opened'] = false;
            $value['children']        = $item->getSubmodulos($item->submodulos,$idrol);
            $data[]                   = $value;
        }

        if(count($data) == 1)
            if(count($data[0]['children']) == 0)
                return [];
        return $data;
    }

    public function getSubmodulos($submodulo, $idrol){
        return collect($submodulo)
        ->map(function($item) use ($submodulo, $idrol){
            $value                    = [];
            $value['id']              = 'm-'.$item->id;
            $value['text']            = $item->descripcion;
            $value['state']['opened'] = true;
            $value['children']        = $this->getFuncionSubmodulo($item->id, $item->url, $idrol);

            return $value;
        })->values()->all();
        
    }

    public function getFuncionSubmodulo($idsubmodulo, $url, $idrol){
        $children = [];
        $funcion_submodulo = FuncionSubmodulo::with('funcion')->where('idsubmodulo', $idsubmodulo)->get();

        foreach ($funcion_submodulo as $key => $item) {
            $value                      = [];
            $value['id']                = 'f-'.$idsubmodulo.'-'.$item["funcion"]->funcion;
            $value['text']              = $item["funcion"]->descripcion;

            if($item["funcion"]->icono  == null){
                $value["icon"]          = "fe fe-code";
            }else{
                $value['icon']          = $item["funcion"]->icono;
            }

            $value['state']['selected'] = $this->getPermiso($url, $item["funcion"]->funcion, $idrol);
            $value['state']['opened']   = $this->getPermiso($url, $item["funcion"]->funcion, $idrol);
            
            $children[]                   = $value;
        }

        return $children;
    }

    public function getPermiso($url, $funcion, $idrol){
        $query = Permission::select('r_p.*')
            ->join('role_has_permissions as r_p', 'permissions.id', '=', 'r_p.permission_id')
            ->where('permissions.name', $funcion.'-'.$url)
            ->where('r_p.role_id', $idrol)->first();
        
        if($query)
            return true;
        return false;
    }

    public function menu(){
        $modulos = static::accesoSubmodulos()->selectRaw('id, descripcion, icono')->orderBy('orden')->get();
        $menus = [];

        foreach ($modulos as $item) {
            if($item->submodulos->count()){
                $value            = [];
                $value['text']    = $item->descripcion;
                $value['icono']   = $item->icono;
                $value['submenu'] = $item->getSubmodulo($item->submodulos);
                $menus[]          = $value;
            }
        }
        return $menus;
    }

    public function scopeAccesoSubmodulos($query){
        
        $data = DB::table('model_has_roles')->where('model_id', auth()->user()->idempleado)->first();

        $rol = [$data->role_id];

        return $query->with(['submodulos' => function($q) use ($rol){
            $q->join('accesos', 'accesos.idsubmodulo', '=', 'submodulos.id');
            $q->whereIn('accesos.idrol', $rol);
            $q->whereNull('accesos.deleted_at');
            $q->orderBy('submodulos.orden');
        }]);
    }

    public function getSubmodulo($submodulos){
        return collect($submodulos)
            ->map(function($item) use ($submodulos){
                $value            = [];
                $value['id']      = $item->id;
                $value['text']    = $item->descripcion;
                $value['icon']    = $item->icon;
                $value['url']     = $item->url;
                return $value;
            })->values()->all();
    }
}