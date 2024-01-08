<?php

namespace App\Http\Controllers\almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


use App\Models\seguridad\Funcion;
use App\Models\almacen\Compra;
use App\Models\almacen\CompraCredito;
use App\Models\almacen\DetalleCompra;
use App\Models\almacen\Producto;
use App\Models\almacen\PresentacionProducto;

class ComprasController extends Controller
{
    protected $modulo = "Almacen";
    protected $submodulo = "Compras";
    protected $dir_modulo = "almacen";
    protected $dir_submodulo = "compras";
    protected $path_controller = null;

    protected $model = null;
    protected $table = null;

    public function __construct()
    {   
        foreach (Funcion::get() as $key => $value) {
            $this->middleware('permission:' . $value["funcion"].'-'.$this->dir_submodulo, ['only' => [$value["funcion"]]]);
        }

        $this->path_controller = $this->dir_modulo."_".$this->dir_submodulo;
        $this->model = new Compra();
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
        $data["presentaciones"] = PresentacionProducto::get();
        $data["data"]           = [];

        if($id != null){
            $data["data"]      = Compra::with('proveedor')->with('detalle_compra.producto')->with('compras_credito')->find($id);
        }
        return $data;
    }

    public function index()
    {   
        return view($this->dir_modulo.'/'.$this->dir_submodulo.'/index', $this->form());
    }

    public function grilla()
    {
        $objeto = Compra::with('detalle_compra')->withTrashed()->get();
        return DataTables::of($objeto)
            ->addIndexColumn()
            ->addColumn("proveedor", function ($objeto) {
                return $objeto->proveedor->descripcion;
            })
            ->addColumn("total", function ($objeto) {
                $total = 0.00;
                foreach ($objeto->detalle_compra as $key => $value) {
                    $total = $total + $value->cantidad*$value->precio_unit;
                }

                if($objeto->igv == 2){
                    $total = $total + (($total*18)/100);
                }

                if($objeto->hay_descuento == 2){
                    $total = $total - $objeto->descuento;
                }

                return "S/. ".number_format($total, 2, '.', '');
            })
            ->addColumn("tipo", function ($objeto) {
                $tipo = "Contado";
                if($objeto->tipo_compra == 2)
                    $tipo = "Crédito";
                return $tipo;
            })
            ->addColumn("acciones", function ($objeto) {
                $btn = "";
                if($objeto->tipo_compra == 2){
                    $btn_watch = '<a href="#" id="btn-watch" class="btn btn-outline-info" onclick="form_watch('.$objeto->id.')"><i class="fa fa-eye"></i></a>';
                    $btn_pay = '<a href="#" id="btn-pay" class="btn btn-outline-success" onclick="form_pay('.$objeto->id.')"><i class="fa fa-money"></i></a>';
                    $btn = $btn_watch.$btn_pay;
                }
                return $btn;
            })
            ->rawColumns(["proveedor", "total", "tipo", 'acciones'])
            ->make(true);
    }

    public function create()
    {
        return view($this->dir_modulo.'/'.$this->dir_submodulo."/form", $this->form());
    }

    public function store(Request $request)
    {
        
        $this->validate($request, [
            'descripcion_proveedor' => 'required',
            'tipo_comprobante' => 'required',
            'serie_comprobante'  => 'required',
            'numero_comprobante' => 'required',
            'fecha_compra' => 'required|date',
            'igv' => 'required',
            'hay_descuento' => 'required',
            'descuento' => 'required_if:hay_descuento,=,2',
            'tipo_compra' => 'required_if:id,!=,null'
        ], [
            'descripcion_proveedor.required' => 'Debes seleccionar el proveedor',
            'tipo_comprobante.required'  => 'Debes seleccionar el tipo de comprobante',
            'serie_comprobante.required' => 'Debes escribir la serie del comprobante',
            'numero_comprobante.required' => 'Debes escribir el número del comprobante',
            'fecha_compra.required' => 'Debes seleccionar la fecha de compra',
            'fecha_compra.date' => 'La fecha de compra debe tener el formato de fecha DD/MM/YYYY',
            'igv.required' => 'Indica si se aplica el IGV',
            'hay_descuento.required' => 'Indica si hay algún descuento',
            'descuento.required_if' => 'Debes escribir el monto del descuento',
            'tipo_compra.required' => 'Seleccione el tipo de compra',

        ]);

        return DB::transaction(function() use ($request){
            $obj = Compra::withTrashed()->find($request->id);
            if(empty($obj)){
                $obj = new Compra();
            }

            $obj->fill($request->all());
            $obj->save();

            if(empty($request->productos)){
                throw ValidationException::withMessages(["productos" => "Debes envíar como mínimo un producto"]);
            }
            //dd($request->all());
            foreach ($request->productos as $key => $value) {
                if($key == 0){
                    $del = DetalleCompra::where('idcompra', $obj->id)->delete();

                    $rec = DetalleCompra::where('idcompra', $obj->id)->orderBy('deleted_at', 'desc')->take($del)->withTrashed()->get();

                    foreach ($rec as $key => $det_del) {
                        
                        $prod = Producto::where('id', $det_del->idproducto)->first();
                        if($det_del->tipo_presentacion == 1){
                            $prod->decrement('stock', $det_del->cantidad);

                        }else{
                            $presentacion = PresentacionProducto::where('id', $det_del->idpresentacion_producto)->first();
                            $prod->decrement('stock', $det_del->cantidad*$presentacion->cantidad);
                        }
                        $prod->save();
                    }
                }
                
                $obj2 = DetalleCompra::withTrashed()->find($value["id"]);
                if(empty($obj2)){
                    $obj2 = new DetalleCompra();
                }

                $obj2->fill($value);
                $obj2->idcompra = $obj->id;
                $obj2->deleted_at = null;
                if($value["tipo_presentacion"] == 1){
                    $obj2->idpresentacion_producto = null;
                }
                $obj2->save();

                $prod = Producto::where('id', $value["idproducto"])->first();
                if($value["tipo_presentacion"] == 1){
                    $prod->increment('stock', $value["cantidad"]);
                }else{
                    $presentacion = PresentacionProducto::where('id', $value["idpresentacion_producto"])->first();
                    $prod->increment('stock', $value["cantidad"]*$presentacion->cantidad);
                }
                $prod->precio_venta = $value["precio_venta"];
                $prod->save();
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
        $obj = Compra::withTrashed()->find($request->id);

        if ($request->accion == "eliminar") {
            $obj->delete();
        }else{
            $obj->restore();
        }
        
        $det_compra = DetalleCompra::where('idcompra', $obj->id)->where('updated_at', $obj->updated_at)->withTrashed()->get();
        
        foreach ($det_compra as $key => $value) {
            $prod = Producto::where('id', $value->idproducto)->first();

            if($request->accion == "eliminar"){
                $value->delete();
                $prod->decrement('stock', $value->cantidad);
            }else{
                $value->restore();
                $prod->increment('stock', $value->cantidad);
            }
            $prod->save();

        }
        
        return response()->json();
    }

    public function form_watch($id){
        return view($this->dir_modulo.'/'.$this->dir_submodulo."/form_watch", $this->form($id));


    }

    public function form_pay($id){
        return view($this->dir_modulo.'/'.$this->dir_submodulo."/form_pay", $this->form($id));
    }

    public function pay(Request $request){
        $this->validate($request, [
            'fecha_pago' => 'required',
            'letra' => 'required|numeric',
        ], [
            'fecha_pago.required' => 'Debes seleccionar la fecha de pago.',
            'letra.required'  => 'Debes escribir el monto pagado.',
            'letra.numeric'  => 'El monto pagado debe ser un número.',
        ]);

        return DB::transaction(function() use ($request){
            $obj = new CompraCredito();
            $obj->fill($request->all());
            $obj->idcompra = $request->id;
            $obj->save();

            return response()->json($obj);
        });
    }

}