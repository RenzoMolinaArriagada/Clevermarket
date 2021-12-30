<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaProducto extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'fichasproductos';

    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dpi_min',
        'dpi_max',
        'ancho',
        'alto',
        'largo',
        'largoCable',
        'peso',
        'botonesProgramables'
    ];    

    public function fichable(){
    	return $this->morphTo();
    }
}
