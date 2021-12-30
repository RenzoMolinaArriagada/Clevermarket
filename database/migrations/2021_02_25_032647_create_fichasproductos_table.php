<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichasproductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichasproductos', function (Blueprint $table) {
            $table->id();
            $table->string('dpi_min')->nullable();
            $table->string('dpi_max')->nullable();
            $table->string('ancho')->nullable();
            $table->string('alto')->nullable();
            $table->string('largo')->nullable();
            $table->string('tipo_luz')->nullable();
            $table->string('largoCable')->nullable();
            $table->string('peso')->nullable();
            $table->string('botonesProgramables')->nullable();
            $table->integer('fichable_id');
            $table->string('fichable_type');
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
        Schema::dropIfExists('fichasproductos');
    }
}
