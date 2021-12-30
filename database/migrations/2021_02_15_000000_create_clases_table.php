<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('activo')->default('1');
            $table->timestamps();
        });

        Schema::create('clase_categoria', function (Blueprint $table) {
            $table->id();
            $table->integer('id_clase');
            $table->integer('id_categoria');
            $table->timestamps();
        });  

  

   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clases');
        Schema::dropIfExists('clase_categoria');
    }
}
