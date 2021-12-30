<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'perfil',
        'url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName(){
        return 'url';
    }

    public function carros(){
        return $this->hasMany(Carro::class,'user_id','id');
    }

    public function tienePerfil(){
        return $this->belongsTo(Perfil::class,'perfil','id');
    }

    public function productosCarro(){
        if($this->carros->where('estado','=',1)->count() > 0){
            return $this->carros->where('estado','=',1);
        }
        else{
            return NULL;
        }
        
    }

    public function desactivarCarro(){
        foreach($this->carros->where('estado','=',1) as $itemCarro){
            $itemCarro->estado = 0;
            $itemCarro->save();
        }
        return true;
    }

    public function buscarEnCarro(int $idProducto){
        return $this->carros->where('producto_id','=',$idProducto)->where('estado','=',1);
    }

    public function contarCarro(){
        return $this->carros->where('estado','=',1)->count();
    }

    public function vistos(){
        return $this->hasMany(Visto::class,'user_id','id');
    }

    public function haVisto(int $idProducto){
        return $this->vistos->where('producto_id','=',$idProducto());
    }

    public function compras(){
        return $this->hasMany(Venta::class,'user_id','id');
    }

    public function getCompras(){
        $compras = $this->compras;
        if($compras->count() > 0){
            return $compras;
        }
        else{
            return NULL;
        }
    }

    public static function getActivos(){
        return User::where('activo','=',1)->get();
    }

    public static function getPorEmail($email){
        return User::where('email','=',$email)->first();
    }

}
