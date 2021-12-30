<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function getRouteKeyName(){
        return 'nombre';
    }

    public static function getMarcaPorNombre(String $nombre){
        return Marca::where('nombre','=',$nombre)->first();
    }

    public function productos(){
    	return $this->hasMany(Producto::class,'id_marca','id');
    }

    public function productosActivos(){
        return $this->productos->where('activo','=',1)->where('id_marca','=',$this->id);
    }
}
