<?php

namespace App\Http\Controllers\almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

use App\Models\seguridad\Funcion;
use App\Models\almacen\Producto;
use App\Models\almacen\TiposProducto;
use App\Models\almacen\UnidadMedida;

class ProductosController extends Controller
{
    protected $modulo = "Almacen";
    protected $submodulo = "Productos";
    protected $dir_modulo = "almacen";
    protected $dir_submodulo = "productos";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }

        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new Producto();
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

        $data["tipos_producto"] = TiposProducto::get();
        $data["unidades_medida"] = UnidadMedida::get();

        if($id != null){
            $data["data"]      = Producto::find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = Producto::with('unidad_medida')->withTrashed();
        return DataTables::of($objeto)
            ->addIndexColumn()
            ->addColumn("venta_directa_", function ($objeto) {
                if($objeto->venta_directa == 1){
                    return "No";
                }

                if($objeto->venta_directa == 2){
                    return "Si";
                }
            })
            ->addColumn("stock_", function ($objeto) {
                return $objeto->stock." ".$objeto->unidad_medida->abreviatura;
            })
            ->addColumn("activo", function ($objeto) {
                return (is_null($objeto->deleted_at)) ? '<span class="dot-label bg-success" title="Activo">Activo</span>' : '<span class="dot-label bg-danger" title="Inactivo">Eliminado</span>';
            })
            ->rawColumns(["activo", "venta_directa_", "stock_"])
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
            'idunidad_medida' => 'required',
            'venta_directa' => 'required',
            'precio_venta' => 'required_if:venta_directa,=,2'
        ], [
            'descripcion.required' => 'Debes escribir el nombre del producto',
            'idunidad_medida.required' => 'Debes seleccionar la unidad de medida',
            'venta_directa.required' => 'Debes indicar si el producto es para venta directa',
            'precio_venta.required_if' => 'Debes escribir el precio de venta',
        ]);

        return DB::transaction(function() use ($request){
            $obj = Producto::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new Producto();
            }

            $obj->fill($request->all());
            if(empty($request->precio_venta)){
                $obj->precio_venta = 0;
            }
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
        $obj = Producto::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            $obj->delete();
            return response()->json($obj);
        }
        $obj->restore();
        return response()->json();
    }

    public function buscar($search){
        $search           = str_replace(' ', '', urldecode($search));;

        $objeto     = Producto::whereRaw("descripcion like (?)", ["%{$search}%"])->where('id', '!=', 1);

        $datos["search"]  = $objeto->take(10)->get();
        return $datos;
    }

    public function buscar_carta($search){
        $search           = str_replace(' ', '', urldecode($search));;

        $objeto     = Producto::whereRaw("descripcion like (?)", ["%{$search}%"])->where('id', '!=', 1)->where('venta_directa', '=', 2);
        $datos["search"]  = $objeto->take(10)->get();
        return $datos;
    }
}