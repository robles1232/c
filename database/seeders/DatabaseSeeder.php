<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use function PHPUnit\Framework\callback;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        $this->call(S1_SeguridadSeeder::class);
        $this->call(S2_AlmacenSeeder::class);
        $this->call(S3_GestionLocalSeeder::class);
        $this->call(PermissionSeeder::class);

        $this->call(AlmacenSeeder::class);
        $this->call(LocalSeeder::class);
    }
}
