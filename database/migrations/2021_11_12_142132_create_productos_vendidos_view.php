<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosVendidosView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE VIEW productos_vendidos AS SELECT prod.sku, prod.nombre, marcas.nombre as marca, vede.cantidad_articulos,prod.precio, (vede.cantidad_articulos * prod.precio) AS total FROM ventas_detalles vede INNER JOIN productos prod ON vede.id_producto = prod.id INNER JOIN marcas ON prod.id_marca = marcas.id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW productos_vendidos');
    }
}
