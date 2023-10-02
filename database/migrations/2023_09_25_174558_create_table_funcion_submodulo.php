<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFuncionSubmodulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcion_submodulo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idsubmodulo');
            $table->foreign('idsubmodulo')->references('id')->on('submodulos');
            $table->unsignedBigInteger('idfuncion');
            $table->foreign('idfuncion')->references('id')->on('funciones');
            
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
        Schema::dropIfExists('funcion_submodulo');
    }
}
