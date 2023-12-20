<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCartaSeccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carta_seccion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idcarta');
            $table->foreign('idcarta')->references('id')->on('cartas');
            $table->unsignedBigInteger('idseccion');
            $table->foreign('idseccion')->references('id')->on('seccion_carta');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carta_seccion');
    }
}
