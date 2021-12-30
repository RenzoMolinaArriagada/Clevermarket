<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntegracionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integraciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->string('code')->nullable();
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('redirect_uri')->nullable();
            $table->string('tipo')->nullable();
            $table->integer('activo')->default('1');
            $table->timestamps();
        });

        Schema::create('integraciones_productos', function (Blueprint $table) {
            $table->id();
            $table->string('id_integracion')->nullable();
            $table->string('id_producto')->nullable();
            $table->string('id_producto_externo')->nullable();
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
        Schema::dropIfExists('integraciones');
        Schema::dropIfExists('integraciones_productos');
    }
}
