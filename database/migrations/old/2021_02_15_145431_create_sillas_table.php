<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sillas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nombre_fabricante')->nullable();
            $table->mediumText('descripcion');
            $table->integer('precio');
            $table->integer('id_marca');
            $table->integer('cantidad')->default('0');
            $table->string('url')->index();
            $table->string('imagen_principal');
            $table->integer('activo')->default('1');
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
        Schema::dropIfExists('sillas');
    }
}
