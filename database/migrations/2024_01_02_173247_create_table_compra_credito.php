<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCompraCredito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_credito', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idcompra');
            $table->foreign('idcompra')->references('id')->on('compras');
            $table->decimal('letra', 8,2);
            $table->date('fecha_pago');
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
        Schema::dropIfExists('compra_credito');
    }
}
