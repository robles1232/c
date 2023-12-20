<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDetalleCompra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_compra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idcompra');
            $table->foreign('idcompra')->references('id')->on('compras');

            $table->unsignedBigInteger('idproducto');
            $table->foreign('idproducto')->references('id')->on('productos');

            $table->double('cantidad', 8, 2);
            $table->float('precio_unit', 8, 2);
            
            $table->unsignedBigInteger('tipo_presentacion')->comment('1 == unitario || 2 == otras presentaciones');
            
            $table->unsignedBigInteger('idpresentacion_producto')->nullable();
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
        Schema::dropIfExists('detalle_compra');
    }
}
