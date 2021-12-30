<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcasPaisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('pais')->nullable();
            $table->timestamps();
        });
        
        Schema::create('paises', function (Blueprint $table) {
            $table->id();
            $table->smallinteger('code');
            $table->char('iso3166a1',2)->nullable();
            $table->char('iso3166a2',3)->nullable();
            $table->string('nombre')->nullable();
            $table->timestamps();
        });

        DB::unprepared(file_get_contents(base_path('database/migrations/data/paises.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/data/marcas.sql')));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcas');
        Schema::dropIfExists('paises');
    }
}
