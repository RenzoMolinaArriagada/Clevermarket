<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'clases';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre'
    ];

    public static function activos(){
        return Clase::where('activo','=',1)->get();
    }

    public function getRouteKeyName(){
        return 'nombre';
    }

    public function productos(){
    	return $this->hasMany(Producto::class,'id_clase','id');
    }

    public function categorias(){
    	return $this->belongsToMany(Categoria::class,'clase_categoria','id_clase','id_categoria');
    }

    public function productosActivos(){
        return $this->productos->where('activo','=',1)->where('id_clase','=',$this->id);
    }

    public static function getClasePorNombre(String $nombre){
        return Clase::where('nombre','=',$nombre)->first();
    }

}
