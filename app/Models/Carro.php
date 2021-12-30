<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;
    
    protected $table = 'carro';

   	protected $fillable = ['user_id','cantidad'];

    public function producto(){
    	return $this->belongsTo(Producto::class,'producto_id','id');
    }
}
