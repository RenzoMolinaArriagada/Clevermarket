<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Audit extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'audits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'perfil_id',
        'modulo',
        'funcion',
        'status'
    ];

    public function perfil(){
        return $this->belongsTo(Perfil::class,'perfil_id','id');
    }
	/*
	@group Funciones de auditoria
    Registra movimientos dentro de la pagina
     if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),__METHOD__,"completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),__METHOD__,"completado");
        }
    */
    public static function guardar(String $guest_uuid, String $nombreClase, String $nombreFuncion,String $status){
    	if(Auth::check()){
    		$usuario = Auth::user();
    		$registro = Audit::create([
    			'user_id' => $usuario->email,
                'perfil_id' => $usuario->perfil,
    			'modulo' => $nombreClase,
    			'funcion' => $nombreFuncion,
    			'status' => $status
    		]);
    	}
    	else{
			$registro = Audit::create([
    			'user_id' => $guest_uuid,
                'perfil_id' => 5,
    			'modulo' => $nombreClase,
    			'funcion' => $nombreFuncion,
    			'status' => $status
    		]);
    	}
    }

    public static function paginateConFiltros($filtro){
        $queryAudits = new Audit();
        if($filtro['usuario'] != NULL){
            $queryAudits = $queryAudits->where('user_id','like','%'.$filtro['usuario'].'%');
        }
        if($filtro['perfil'] != NULL){
            $queryAudits = $queryAudits->where('perfil_id','=',$filtro['perfil']);
        }
        if($filtro['modulo'] != NULL){
            $queryAudits = $queryAudits->where('modulo','like','%'.$filtro['modulo'].'%');
        }
        if($filtro['accion'] != NULL){
            $queryAudits = $queryAudits->where('funcion','like','%'.$filtro['accion'].'%');
        }
        if($filtro['estado'] != NULL){
            $queryAudits = $queryAudits->where('status','=',$filtro['estado']);
        }
        if($filtro['fechaini'] != NULL){
            $queryAudits = $queryAudits->where('created_at','>=',$filtro['fechaini']);
        }
        if($filtro['fechahasta'] != NULL){
            $queryAudits = $queryAudits->where('created_at','<=',$filtro['fechahasta']);
        }
        foreach ($filtro as $f) {
            if($f != NULL){
                return $queryAudits->paginate(100);
            }
        }
        return $queryAudits->paginate(30);
    }
}
