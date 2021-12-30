<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Visto extends Model
{
    use HasFactory;
    /*
    **
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'vistos';

    public function producto(){
    	return $this->belongsTo(Producto::class,'producto_id','id');
    }

    /*
    *
    * Busca los productos con mas vistas en general, limite 20
    *
    *
    *@return Collection[Producto::class]
    */
    public static function masVistos(){
    	$productos = new Collection();
    	$result = DB::table('productos')
    					->join('vistos', function($join){
    						$join->on('productos.id','=','vistos.producto_id')
    						->orderBy('vistos.veces_visto','asc');
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

    public function usuarioHaVisto($idUsuario, int $idProducto){
    	if($this->where('producto_id','=',$idProducto)->where('user_id','=',$idUsuario)->count() > 0){
    		return $this->where('producto_id','=',$idProducto)
    	->where('user_id','=',$idUsuario)->first();
    	}
    	else{
    		return NULL;
    	}
    }

    public function recomendaciones($idUsuario){
    	if($this->where('user_id','=',$idUsuario)->count() > 0){
    		return $this->where('user_id','=',$idUsuario)->orderBy('veces_visto','asc')->get();
    	}
    	else{
    		return NULL;
    	}
    }

}
