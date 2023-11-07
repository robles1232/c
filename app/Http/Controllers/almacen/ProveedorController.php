<?php

namespace App\Http\Controllers\almacen;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\seguridad\Funcion;
use App\Models\almacen\Proveedor;


class ProveedorController extends Controller
{
    protected $modulo = "Almacen";
    protected $submodulo = "Proveedores";
    protected $dir_modulo = "almacen";
    protected $dir_submodulo = "proveedores";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }

        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new Proveedor();
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
            $data["data"]      = Proveedor::find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = Proveedor::withTrashed()->get();
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
            'ruc' => 'required|integer|digits:11',
            'direccion' => 'required',
            'telefono' => 'required',
        ], [
            'descripcion.required' => 'Debes escribir la Razón social del Proveedor',
            'ruc.required' => 'Debes escribir el ruc del proveedor',
            'ruc.integer' => 'El ruc debe ser un número de 11 dígitos',
            'ruc.digits' => 'El ruc debe ser un número de 11 dígitos',
            'direccion.required' => 'Debes escribir la dirección del proveedor',
            'telefono.required' => 'Debes escribir el teléfono del proveedor',
        ]);
        return DB::transaction(function() use ($request){
            $obj = Proveedor::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new Proveedor();
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
        $obj = Proveedor::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            $obj->delete();
            return response()->json($obj);
        }
        $obj->restore();
        return response()->json();
    }

    public function buscar($search){
        $search           = str_replace(' ', '', urldecode($search));;

        $objeto     = Proveedor::where('ruc','like','%'.$search.'%')->orwhereRaw("REPLACE(descripcion,' ', '') ilike ?",["%".$search."%"]);

        $datos["search"]  = $objeto->take(10)->get();
        return $datos;
    }
}