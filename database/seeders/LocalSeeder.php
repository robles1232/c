<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\local\Mesa;
use App\Models\local\SeccionCarta;

class LocalSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        //------------------MESAS
        $data = new Mesa();
        $data->descripcion = "Mesa 1";
        $data->sitios = "4";
        $data->save();

        $data = new Mesa();
        $data->descripcion = "Mesa 2";
        $data->sitios = "4";
        $data->save();

        $data = new Mesa();
        $data->descripcion = "Mesa 3";
        $data->sitios = "2";
        $data->save();

        $data = new Mesa();
        $data->descripcion = "Mesa 4";
        $data->sitios = "6";
        $data->save();

        //SECCIÓN DE CARTA
        $data = new SeccionCarta();
        $data->descripcion = "Hamburguesas";
        $data->orden = 1;
        $data->save();

        $data = new SeccionCarta();
        $data->descripcion = "Bebidas";
        $data->orden = 2;
        $data->save();

        $data = new SeccionCarta();
        $data->descripcion = "Refrescos";
        $data->orden = 2;
        $data->save();
    }
}