<?php

namespace Database\Seeders;

use App\Models\local\Mesa;
use Illuminate\Database\Seeder;

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
    }
}