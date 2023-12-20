<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCartaSeccionDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carta_seccion_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idcarta_seccion');
            $table->foreign('idcarta_seccion')->references('id')->on('carta_seccion');

            $table->unsignedBigInteger('tipo'); //1 = Plato || 2 = Producto
            $table->unsignedBigInteger('idplato')->nullable();
            $table->unsignedBigInteger('idproducto')->nullable();
            
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
        Schema::dropIfExists('carta_seccion_detalle');
    }
}
