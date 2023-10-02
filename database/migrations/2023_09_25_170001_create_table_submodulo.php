<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSubmodulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submodulos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idmodulo');
            $table->foreign('idmodulo')->references('id')->on('modulos');
            $table->string('descripcion');
            $table->string('abreviatura');
            $table->text('url');
            $table->integer('orden');
            $table->string('icono')->nullable();
            
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
        Schema::dropIfExists('submodulos');
    }
}
