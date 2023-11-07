<?php

namespace Database\Seeders;

use App\Models\seguridad\Accesos;
use App\Models\seguridad\FuncionSubmodulo;
use App\Models\seguridad\Modulo;
use App\Models\seguridad\Submodulo;
use Illuminate\Database\Seeder;


class S2_AlmacenSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
                
        //------------------- MODULOS
        $modulo = new Modulo();
        $modulo->descripcion = "Almacen";
        $modulo->abreviatura = "alm.";
        $modulo->icono       = "fe fe-box";
        $modulo->orden       = 1;
        $modulo->save();

        //----------------- Submodulos
        /**SUBMÓDULO */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = $modulo->id;
        $submodulo->descripcion = "Unidades de Medida";
        $submodulo->abreviatura = "UMd.";
        $submodulo->url         = "unidades_medida";
        $submodulo->orden       = 1;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 2;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 3;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 4;
        $funcion_submodulo->save();
        
        /**SUBMÓDULO */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = $modulo->id;
        $submodulo->descripcion = "Tipos de Producto";
        $submodulo->abreviatura = "TP.";
        $submodulo->url         = "tipos_producto";
        $submodulo->orden       = 2;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 2;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 3;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 4;
        $funcion_submodulo->save();

        /**SUBMÓDULO */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = $modulo->id;
        $submodulo->descripcion = "Marcas";
        $submodulo->abreviatura = "mr.";
        $submodulo->url         = "marcas";
        $submodulo->orden       = 3;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 2;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 3;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 4;
        $funcion_submodulo->save();

        /**SUBMÓDULO */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = $modulo->id;
        $submodulo->descripcion = "Proveedores";
        $submodulo->abreviatura = "pr.";
        $submodulo->url         = "proveedores";
        $submodulo->orden       = 4;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 2;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 3;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 4;
        $funcion_submodulo->save();


        /**SUBMÓDULO */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = $modulo->id;
        $submodulo->descripcion = "Productos";
        $submodulo->abreviatura = "pr.";
        $submodulo->url         = "productos";
        $submodulo->orden       = 5;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 2;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 3;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 4;
        $funcion_submodulo->save();

        /**SUBMÓDULO */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = $modulo->id;
        $submodulo->descripcion = "Compras";
        $submodulo->abreviatura = "cr.";
        $submodulo->url         = "compras";
        $submodulo->orden       = 6;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 2;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 3;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 4;
        $funcion_submodulo->save();
    }
}
