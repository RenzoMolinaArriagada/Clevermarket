<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Producto extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'productos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku',
        'id_clase',
        'nombre',
        'nombre_fabricante',
        'descripcion',
        'precio',
        'id_marca',
        'cantidad',
        'url',
        'imagen_principal'
    ];

    public static function activosPorClase(Clase $clase){
        return Producto::where('activo','=',1)
            ->where('id_clase','=',$clase->id)
            ->paginate(12);
    }

    public static function todosPorClase(Clase $clase){
        return Producto::where('id_clase','=',$clase->id)
            ->paginate(12);
    }

    public static function masVendidos(){
        $productos = new Collection();
        $result = DB::table('productos')
                        ->join('ventas_detalles', function($join){
                            $join->on('productos.id','=','ventas_detalles.id_producto')
                            ->orderByRaw('SUM(ventas_detalles.cantidad_articulos)');
                        })
                        ->select('productos.*')
                        ->groupBy('productos.id')
                        ->limit('20')
                        ->get();                       
        foreach ($result as $producto) {
            $producto = json_decode(json_encode($producto), true);
            $prod = new Producto($producto);
            $productos->push($prod);
        }
        return $productos;
    }

    public function marca(){
        return $this->hasOne(Marca::class,'id','id_marca');
    }

    public function getRouteKeyName(){
        return 'url';
    }

    /*
    public function ficha(){
        return $this->hasOne(FichaProducto::class);
    }
    */


    public function vistos(){
        return $this->hasMany(Visto::class,'producto_id','id');
    }

    public function vecesVisto(){
        return $this->vistos->count();
    }

    public function clase(){
    	return $this->belongsTo(Clase::class,'id_clase','id');
    }

    public function enCarro(){
        return $this->hasMany(Carro::class,'producto_id','id');
    }

    public function integraciones(){
        return $this->belongsToMany(Integraciones::class,'integraciones_productos','id_producto','id_integracion')
            ->withPivot('id_producto_externo')
            ->withTimestamps();
    }

    public function integradoML(){
        return $this->integraciones->where('marketplace','=','mercadolibre')->first();
    }

    public function integradoLinio(){
        return $this->integraciones->where('marketplace','=','linio')->first();
    }
}
