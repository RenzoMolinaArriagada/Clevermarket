<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;
use App\Models\Audit;
use App\Models\Visto;


class VistoController extends Controller
{
    public static function guardarVisualizacion(Request $request,Producto $producto){
    	if (!$request->session()->has('guest_uuid')) {
    		$request->session()->put('guest_uuid',Str::uuid());
    		$user_id = $request->session()->get('guest_uuid');
    	}else{
    		$user_id = $request->session()->get('guest_uuid');
    	}
    	$visto = new Visto;
    	$visto->producto_id = $producto->id;
    	if(!Auth::check()){
    		$visto->user_id = $user_id->toString();
	    	if(is_null($visto->usuarioHaVisto($visto->user_id,$producto->id))){
	    		$visto->veces_visto = 1;
	    		$visto->save();
	    	}
	    	else{
	    		$visto = $visto->usuarioHaVisto($visto->user_id,$producto->id);
	    		$visto->veces_visto +=1;
	    		$visto->save();
	    	}
   		}else
   		{
   			$visto->user_id = Auth::user()->id;
   			if(is_null($visto->usuarioHaVisto(Auth::user()->id,$producto->id))){
	    		$visto->veces_visto = 1;
	    		$visto->save();
	    	}
	    	else{
	    		$visto = $visto->usuarioHaVisto(Auth::user()->id,$producto->id);
	    		$visto->veces_visto +=1;
	    		$visto->save();
	    	}
   		}
      if (!$request->session()->has('guest_uuid')) {
          $request->session()->put('guest_uuid',Str::uuid());
          Audit::guardar($request->session()->get('guest_uuid'),'VistoController',"Un usuario ha visto el producto ". $producto->nombre .".","completado");
      }
      else{
          Audit::guardar($request->session()->get('guest_uuid'),'VistoController',"Un usuario ha visto el producto ". $producto->nombre .".","completado");
      }
    }

    public static function recomendaciones(Request $request){
    	if (!$request->session()->has('guest_uuid')) {
    		$request->session()->put('guest_uuid',Str::uuid());
    		$user_id = $request->session()->get('guest_uuid');
    	}else{
    		$user_id = $request->session()->get('guest_uuid');
    	}
    	$visto = new Visto;
    	if(!Auth::check()){
    		$user_id = $user_id->toString();
    		if(!is_null($visto->recomendaciones($user_id))){
	    		$vistos = $visto->recomendaciones($user_id);
	    		$productos = new Collection();
	    		foreach ($vistos as $visto) {
	    			if($visto->producto != NULL){
	    				$productos->push($visto->producto);
	    			}
	    		}
	    		return $productos;
    		}
    		else{
    			return VistoController::recomendacionesCarro();
    		}
  		}
  		else{
  			$user_id = Auth::user()->id;
  			if(!is_null($visto->recomendaciones($user_id))){
    			$vistos = $visto->recomendaciones($user_id);
    			$productos = new Collection();
    			foreach ($vistos as $visto) {
    				if($visto->producto != NULL){
	    				$productos->push($visto->producto);
	    			}
	    		}
	    		return $productos;
    		}
    		else{
    			return VistoController::recomendacionesCarro();
    		}
  		}

    }

    public static function recomendacionesCarro(){
    	$vistos = Visto::masVistos();
    	return $vistos;
    }
}
