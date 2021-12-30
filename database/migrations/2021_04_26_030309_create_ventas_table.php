<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->integer('cantidad_articulos')->nullable();
            $table->integer('precio_total')->nullable();
            $table->integer('comuna_id')->nullable();
            $table->string('calle')->nullable();
            $table->integer('numeracion')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('courier_id')->nullable();
            $table->integer('codigo_descuento_id')->nullable();
            $table->timestamps();
        });

        Schema::create('ventas_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('id_venta');
            $table->integer('id_producto');
            $table->integer('cantidad_articulos');
            $table->integer('precio_total');
            $table->integer('estado');
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
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('ventas_detalles');
    }
}
