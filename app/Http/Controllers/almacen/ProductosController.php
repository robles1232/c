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
use App\Models\almacen\PresentacionesProducto;
use App\Models\almacen\PresentacionProducto;

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

        $data["tipos_producto"] = TiposProducto::where('tipo', 2)->get();
        $data["unidades_medida"] = UnidadMedida::get();

        if($id != null){
            $data["data"]      = Producto::with('presentaciones_producto.presentacion')->find($id);
        }

        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = Producto::where('tipo', 2)->with('unidad_medida')->withTrashed();
        return DataTables::of($objeto)
            ->addIndexColumn()
            ->addColumn("stock_", function ($objeto) {
                return $objeto->stock." ".$objeto->unidad_medida->abreviatura;
            })
            ->addColumn("activo", function ($objeto) {
                return (is_null($objeto->deleted_at)) ? '<span class="dot-label bg-success" title="Activo">Activo</span>' : '<span class="dot-label bg-danger" title="Inactivo">Eliminado</span>';
            })
            ->rawColumns(["activo", "stock_"])
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
            'idtipo_producto' => 'required',
            'idunidad_medida' => 'required',
            'precio_venta' => 'required|numeric'
        ], [
            'descripcion.required' => 'Debes escribir el nombre del producto',
            'idtipo_producto.required' => 'Debes seleccionar el tipo de producto',
            'idunidad_medida.required' => 'Debes seleccionar la unidad de medida',
            'precio_venta.required' => 'Debes escribir el precio de venta',
            'precio_venta.numeric' => 'El precio de venta debe ser un número',
        ]);

        return DB::transaction(function() use ($request){
            $obj = Producto::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new Producto();
            }

            $obj->fill($request->all());
            $obj->tipo = 2;
            $obj->save();
            
            PresentacionesProducto::where('idproducto', $obj->id)->delete();
            if(!empty($request->presentaciones_producto)){
                foreach ($request->presentaciones_producto as $key => $value) {
                    $obj2 = PresentacionesProducto::withTrashed()->find($value["id"]);
                    if(empty($obj2)){
                        $obj2 = new PresentacionesProducto();
                    }
                    $obj2->idproducto = $obj->id;
                    $obj2->idpresentacion_producto = $value["idpresentacion_producto"];
                    $obj2->deleted_at = null;
                    $obj2->save();
    
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

        $objeto     = Producto::whereRaw("descripcion like (?)", ["%{$search}%"])->where('id', '!=', 1)->with('presentaciones_producto.presentacion');

        $datos["search"]  = $objeto->take(10)->get();
        return $datos;
    }

    public function buscar_carta($search){
        $search           = str_replace(' ', '', urldecode($search));;

        $objeto     = Producto::whereRaw("descripcion like (?)", ["%{$search}%"])->where('id', '!=', 1)->where('tipo', 2);
        $datos["search"]  = $objeto->take(10)->get();
        return $datos;
    }

    public function getPresentaciones($idproducto){
        $data = PresentacionesProducto::with('presentacion')->where('idproducto', $idproducto)->get();
        return response()->json($data);
    }
}