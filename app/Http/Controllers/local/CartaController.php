<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

use App\Models\seguridad\Funcion;
use App\Models\local\Carta;
use App\Models\local\CartaSeccion;
use App\Models\local\CartaSeccionDetalle;

class CartaController extends Controller
{
    protected $modulo = "Local";
    protected $submodulo = "Cartas";
    protected $dir_modulo = "local";
    protected $dir_submodulo = "cartas";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }

        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new Carta();
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
            $data["data"]      = Carta::with('secciones.seccion')->with('secciones.carta_seccion_detalle.plato')->with('secciones.carta_seccion_detalle.producto')->find($id);
        }
        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = Carta::withTrashed()->get();
        return DataTables::of($objeto)
            ->addIndexColumn()
            ->addColumn("estado", function ($objeto) {
                $estado = "Inactivo";
                if($objeto->estado == 2){
                    $estado = "Carta Actual";
                }
                return $estado;
            })
            ->addColumn("activo", function ($objeto) {
                return (is_null($objeto->deleted_at)) ? '<span class="dot-label bg-success" title="Activo">Activo</span>' : '<span class="dot-label bg-danger" title="Inactivo">Eliminado</span>';
            })
            ->rawColumns(["estado", "activo"])
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
            'estado' => 'required',
        ], [
            'descripcion.required' => 'Debes escribir el nombre de la Carta',
            'descripcion.unique' => 'Esta carta ya está registrada',
            'estado.required' => 'Debes seleccionar el estado de la carta'
        ]);

        return DB::transaction(function() use ($request){
            if(empty($request->secciones_carta)){
                throw ValidationException::withMessages(["secciones_carta" => "Debes enviar las secciones de la carta"]);
            }
            if($request->estado == 2){
                DB::table('cartas')->update(["estado" => 1]);
            }

            $obj = Carta::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new Carta();
            }

            $obj->fill($request->all());
            $obj->save();

            foreach ($request->secciones_carta as $key => $value) {
                if($key == 0)
                    CartaSeccion::where('idcarta', $obj->id)->delete();

                $obj2 = CartaSeccion::withTrashed()->find($value["id"]);
                if(empty($obj2)){
                    $obj2 = new CartaSeccion();
                }
    
                $obj2->idcarta = $obj->id;
                $obj2->idseccion = $value["idseccion_carta"];
                $obj2->deleted_at = null;
                $obj2->save();
                foreach ($value["plato_producto"] as $key2 => $value2) {
                    if($key2 == 0)
                        CartaSeccionDetalle::where('idcarta_seccion', $obj2->id)->delete();

                    $obj3 = CartaSeccionDetalle::withTrashed()->find($value2["id"]);

                    if(empty($obj3)){
                        $obj3 = new CartaSeccionDetalle();
                    }
                    $obj3->idcarta_seccion = $obj2->id;
                    $obj3->tipo = $value2["tipo"];
                    if($value2["tipo"] == 1){
                        $obj3->idplato = $value2["idplato_producto"];
                    }else{
                        $obj3->idproducto = $value2["idplato_producto"];
                    }
                    $obj3->deleted_at = null;
                    $obj3->save();
                }
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
        $obj = Carta::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            $obj->delete();
            return response()->json($obj);
        }
        $obj->restore();
        return response()->json();
    }
}