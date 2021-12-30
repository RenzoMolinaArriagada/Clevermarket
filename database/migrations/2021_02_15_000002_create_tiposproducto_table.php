<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_producto', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('tipos_luz', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('prodtipos_relations', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo_id');
            $table->integer('producto_id');
            $table->string('producto_modelo');
            $table->timestamps();
        });

        DB::unprepared(file_get_contents(base_path('database/migrations/data/tipos_producto.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/data/tipos_luz.sql')));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_producto');
        Schema::dropIfExists('tipos_luz');
    }
}
