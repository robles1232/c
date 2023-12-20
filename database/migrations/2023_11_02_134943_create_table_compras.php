<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCompras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idproveedor');
            $table->foreign('idproveedor')->references('id')->on('proveedores');
            
            $table->unsignedBigInteger('tipo_comprobante')->comment('1 => boleta || 2 => factura');
            $table->string('serie_comprobante', 4);
            $table->unsignedBigInteger('numero_comprobante');
            $table->date('fecha_compra');
            $table->unsignedBigInteger('igv')->default(1);
            $table->unsignedBigInteger('hay_descuento')->default(1);
            $table->decimal('descuento', 8,2)->default(0);
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
        Schema::dropIfExists('compras');
    }
}
