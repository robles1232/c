<?php

namespace Database\Seeders;

use App\Models\seguridad\Accesos;
use App\Models\seguridad\FuncionSubmodulo;
use App\Models\seguridad\Modulo;
use App\Models\seguridad\Submodulo;
use Illuminate\Database\Seeder;


class S3_GestionLocalSeeder extends Seeder
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
        $modulo->descripcion = "Local";
        $modulo->abreviatura = "loc.";
        $modulo->icono       = "fa fa-building-o";
        $modulo->orden       = 1;
        $modulo->save();

        //----------------- Submodulos
        /**SUBMÓDULO */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = $modulo->id;
        $submodulo->descripcion = "Mesas";
        $submodulo->abreviatura = "Mes.";
        $submodulo->url         = "mesas";
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
    }
}
