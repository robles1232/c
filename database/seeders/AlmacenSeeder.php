<?php

namespace Database\Seeders;

use App\Models\almacen\Categoria;
use App\Models\almacen\Marca;
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

        //------------------MARCAS
        $obj = new Marca();
        $obj->descripcion = "Inka Kola";
        $obj->save();

        $obj = new Marca();
        $obj->descripcion = "Pilsen";
        $obj->save();

        //------------------TIPO DE PRODUCTOS
        $obj = new TiposProducto();
        $obj->descripcion = "Bebida";
        $obj->save();

        $obj = new Categoria();
        $obj->idtipo_producto = 1;
        $obj->descripcion = "Gaseosa";
        $obj->save();

        $obj = new Categoria();
        $obj->idtipo_producto = 1;
        $obj->descripcion = "Cerveza";
        $obj->save();

        //-----------------PROVEEDORES
        $obj = new Proveedor();
        $obj->descripcion = "Distribuidora Manquías";
        $obj->ruc = "2099988772";
        $obj->direccion = "Jr. Sauce #111";
        $obj->telefono = "999888777";
        $obj->save();

        //-------------------PRODUCTOS
        $obj = new Producto();
        $obj->descripcion = "Delivery";
        $obj->idunidad_medida = 1;
        $obj->venta_directa = 2;
        $obj->precio_venta = "3.00";
        $obj->por_defecto = true;
        $obj->stock = 99999999;
        $obj->save();

        $obj = new Producto();
        $obj->idtipo_producto = 1;
        $obj->idcategoria = 1;
        $obj->idmarca = 1;
        $obj->idunidad_medida = 1;
        $obj->descripcion = "Inka kola 250ml";
        $obj->venta_directa = 2;
        $obj->precio_venta = "3.00";
        $obj->save();

        $obj = new Producto();
        $obj->idtipo_producto = 1;
        $obj->idcategoria = 1;
        $obj->idmarca = 1;
        $obj->idunidad_medida = 1;
        $obj->descripcion = "Inka kola 1L";
        $obj->venta_directa = 2;
        $obj->precio_venta = "10.00";
        $obj->save();

        $obj = new Producto();
        $obj->idtipo_producto = 1;
        $obj->idcategoria = 2;
        $obj->idmarca = 2;
        $obj->idunidad_medida = 1;
        $obj->descripcion = "Pilsen callao 250";
        $obj->venta_directa = 2;
        $obj->precio_venta = "7.00";
        $obj->save();
    }
}