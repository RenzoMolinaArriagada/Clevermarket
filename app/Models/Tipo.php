<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tipos_producto';

    public function mouse(){
        return $this->morphedByMany(Mouse::class,'prodtipos_relation');
    }

    public function teclados(){
        return $this->morphedByMany(Teclado::class,'prodtipos_relation');
    }

    public function sillas(){
        return $this->morphedByMany(Silla::class,'prodtipos_relation');
    }

    public function getRouteKeyName(){
        return 'nombre';
    }
}
