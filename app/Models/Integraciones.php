<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integraciones extends Model
{
    use HasFactory;

    protected $table = 'integraciones';

    protected $fillable = [
        'nombre',
    	'client_id',
    	'client_secret',
    	'code',
    	'access_token',
    	'refresh_token',
    	'redirect_uri',
        'tipo'
    ];

    public function existeIntegracion(String $nombre){
        $integracion = Integraciones::where('nombre','=',$nombre)->first();
        if($integracion != Null){
            if($integracion->activo == 1){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public static function getIntegracionPorNombre(String $nombre){
        return Integraciones::where('nombre','=',$nombre)->first();
    }

    public static function getCouriers(){
        return Integraciones::where('tipo','=','courier')->where('activo','=',1)->get();
    }

    public function productos(){
        return $this->belongsToMany(Producto::class,'integraciones_productos','id_integracion','id_producto')
            ->withPivot('id_producto_externo')
            ->withTimestamps();
    }

    
}
