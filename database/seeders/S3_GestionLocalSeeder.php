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
        /**MESAS */
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

        /**RECETA */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = $modulo->id;
        $submodulo->descripcion = "Recetas";
        $submodulo->abreviatura = "Rec.";
        $submodulo->url         = "recetas";
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

        /**RECETA */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = $modulo->id;
        $submodulo->descripcion = "Menús";
        $submodulo->abreviatura = "Menu.";
        $submodulo->url         = "menus";
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
    }
}
