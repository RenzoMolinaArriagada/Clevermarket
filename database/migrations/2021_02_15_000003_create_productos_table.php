<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
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
            $table->integer('id_clase');
            $table->string('sku');
            $table->string('nombre');
            $table->string('nombre_fabricante')->nullable();
            $table->mediumText('descripcion');
            $table->integer('precio');
            $table->integer('id_marca');
            $table->integer('cantidad')->default('0');
            $table->string('url')->index();
            $table->string('imagen_principal')->default('images/productos/imagen_no_disponible.png');
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
        Schema::dropIfExists('productos');
    }
}
