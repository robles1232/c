<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePresentacionPresentacionesProducto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentaciones_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idproducto');
            $table->foreign('idproducto')->references('id')->on('productos');
            $table->unsignedBigInteger('idpresentacion_producto');
            $table->foreign('idpresentacion_producto')->references('id')->on('presentacion_productos');
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
        Schema::dropIfExists('presentaciones_producto');
    }
}
