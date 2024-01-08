<?php

namespace Database\Seeders;

use App\Models\almacen\Marca;
use App\Models\almacen\PresentacionProducto;
use Illuminate\Database\Seeder;
use App\Models\almacen\UnidadMedida;
use App\Models\almacen\Proveedor;
use App\Models\almacen\TiposProducto;
use App\Models\almacen\Producto;

class AlmacenSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        $obj = new UnidadMedida();
        $obj->descripcion = "Unidad";
        $obj->abreviatura = "ud";
        $obj->save();

        $obj = new UnidadMedida();
        $obj->descripcion = "Kilogramo";
        $obj->abreviatura = "kg";
        $obj->save();

        $obj = new UnidadMedida();
        $obj->descripcion = "Miligramo";
        $obj->abreviatura = "mg";
        $obj->save();

        $obj = new UnidadMedida();
        $obj->descripcion = "Litro";
        $obj->abreviatura = "lt";
        $obj->save();

        $obj = new UnidadMedida();
        $obj->descripcion = "Mililitro";
        $obj->abreviatura = "ml";
        $obj->save();
        //------------------ Presentaciones
        $obj = new PresentacionProducto();
        $obj->idunidad_medida = 2;
        $obj->descripcion = "Saco 25kg";
        $obj->cantidad = 25;
        $obj->save();

        $obj = new PresentacionProducto();
        $obj->idunidad_medida = 2;
        $obj->descripcion = "Saco 50kg";
        $obj->cantidad = 50;
        $obj->save();

        $obj = new PresentacionProducto();
        $obj->idunidad_medida = 1;
        $obj->descripcion = "Caja 12ud";
        $obj->cantidad = 12;
        $obj->save();

        //------------------TIPO DE PRODUCTOS
        $obj = new TiposProducto();
        $obj->descripcion = "Bebida";
        $obj->tipo = 2;
        $obj->save();

        $obj = new TiposProducto();
        $obj->descripcion = "Fruta";
        $obj->tipo = 1;
        $obj->save();

        //-----------------PROVEEDORES
        $obj = new Proveedor();
        $obj->descripcion = "Distribuidora Isaias";
        $obj->ruc = "2099988772";
        $obj->direccion = "Jr. Sauce #111";
        $obj->telefono = "999888777";
        $obj->save();

        //-------------------PRODUCTOS
        $obj = new Producto();
        $obj->descripcion = "Delivery";
        $obj->tipo = 2;
        $obj->idunidad_medida = 1;
        $obj->precio_venta = "3.00";
        $obj->por_defecto = true;
        $obj->stock = 999;
        $obj->save();

        $obj = new Producto();
        $obj->idtipo_producto = 1;
        $obj->tipo = 2;
        $obj->idunidad_medida = 1;
        $obj->descripcion = "Inka kola 250ml";
        $obj->precio_venta = "3.00";
        $obj->save();

        $obj = new Producto();
        $obj->idtipo_producto = 1;
        $obj->tipo = 2;
        $obj->idunidad_medida = 1;
        $obj->descripcion = "Inka kola 1L";
        $obj->precio_venta = "10.00";
        $obj->save();

        $obj = new Producto();
        $obj->idtipo_producto = 1;
        $obj->tipo = 2;
        $obj->idunidad_medida = 1;
        $obj->descripcion = "Pilsen callao 250";
        $obj->precio_venta = "7.00";
        $obj->save();

        $obj = new Producto();
        $obj->idtipo_producto = 2;
        $obj->tipo = 1;
        $obj->idunidad_medida = 2;
        $obj->descripcion = "Cocona";
        $obj->save();
    }
}