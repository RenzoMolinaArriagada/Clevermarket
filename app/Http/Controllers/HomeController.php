<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Audit;
use App\Models\Producto;
use App\Models\Clase;
use App\Models\Visto;
use App\Models\Venta;

class HomeController extends Controller
{
    public function index(Request $request){
        $masVendidos = Producto::masVendidos();
        $masVistos = Visto::masVistos(); 
    	if (!$request->session()->has('guest_uuid')) {
    		$request->session()->put('guest_uuid',Str::uuid());
    		Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra la pagina principal","completado");
    	}
    	else{
    		Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra la pagina principal","completado");
    	}
    	return view('home.body',[
            'masVendidos' => $masVendidos,
            'masVistos' => $masVistos
        ]);  
    }
}
