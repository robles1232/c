<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('idtipo_producto')->nullable();
            $table->foreign('idtipo_producto')->references('id')->on('tipos_producto');

            $table->unsignedBigInteger('tipo')->comment("1 == ingrediente || 2 == producto");
            $table->unsignedBigInteger('idunidad_medida');
            $table->foreign('idunidad_medida')->references('id')->on('unidades_medida');
            $table->string('descripcion');
            $table->decimal('stock', 8, 2)->default(0);
            $table->decimal('precio_venta', 8, 2)->default(0);
            $table->boolean('por_defecto')->default(false);
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
        Schema::dropIfExists('productos');
    }
}
