<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('url');
            $table->integer('perfil')->default('3');
            $table->integer('activo')->default('1');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('perfiles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        DB::unprepared(file_get_contents(base_path('database/migrations/data/perfiles.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/data/regiones.sql')));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('perfiles');
    }
}
