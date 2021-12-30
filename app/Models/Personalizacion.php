<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personalizacion extends Model
{
    use HasFactory;

    protected $table = 'config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'img_banner',
        'img_logo',
        'tipo_plantilla',
        'fuente',
    ];

    public function comuna(){
        return $this->belongsTo(Comuna::class,'comuna_id','id');
    }
}
