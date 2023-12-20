<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePresentacionProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentacion_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idunidad_medida');
            $table->foreign('idunidad_medida')->references('id')->on('unidades_medida');
            $table->string('descripcion');
            $table->decimal('cantidad', 8,2);
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
        Schema::dropIfExists('presentacion_productos');
    }
}
