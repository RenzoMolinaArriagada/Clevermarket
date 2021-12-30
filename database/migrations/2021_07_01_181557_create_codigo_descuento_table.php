<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodigoDescuentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigo_descuento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('descuento',4,3);
            $table->integer('usos_restantes');
            $table->integer('tipo');
            $table->timestamp('activo_hasta');
            $table->integer('user_id')->nullable();
            $table->boolean('activo')->default(1);
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
        Schema::dropIfExists('codigo_descuento');
    }
}
