<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoDescuento extends Model
{
    use HasFactory;

    protected $table = 'codigo_descuento';

    protected $fillable = [
        'nombre',
        'descuento',
        'usos_restantes',
        'tipo',
        'activo_hasta'
    ];

    public function descontar(){
        if($this->usos_restantes == -1){
            return true;
        }
        elseif ($this->usos_restantes > 0) {
            $this->usos_restantes -= 1;
            $this->save();
            return true;
        }
        elseif ($this->usos_restantes == 0) {
            return false;
        }
    }

    public static function getCodigoIfActivo($nombreValidar){
        if($nombre = NULL){
            return NULL;
        }
        else{
            $fechaAhora = ''.now()->format('Y-m-d');
            return static::where('nombre','=',$nombreValidar)->whereDate('activo_hasta','>=',$fechaAhora)->first();
        }
    }

    public static function activos(){
        return static::where('activo','=','1')->get();
    }
}
