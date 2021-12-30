<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->id();
            $table->string('img_banner')->default('http://forcegamer.test/images/default/universe.jpg');
            $table->string('img_logo')->default('http://forcegamer.test/images/default/logo_default.png');;
            $table->string('color_botones_back')->default('0c215c');
            $table->string('color_botones_front')->default('FFFFFF');
            $table->integer('tipo_plantilla')->nullable();
            $table->string('fuente')->nullable();
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
        Schema::dropIfExists('config');
    }
}
