<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Models\Audit;
use App\Models\Carro;
use App\Models\User;
use App\Models\Producto;
use App\Models\Venta;

class CarroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    *@group Carro de compras
    *Despliega el carro de compras activo
    *
    *@response {
    *"view": "tienda/carro",
    *}
    */
    public function verCarro(Request $request){

    	$carroRaw = Auth::user()->productosCarro();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el carro de compras con las recomendaciones","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el carro de compras con las recomendaciones","completado");
        }
        $recomendaciones = VistoController::recomendaciones($request);
        return view('tienda.carro',[
        	'carroCompleto' => $carroRaw,
            'recomendaciones' => $recomendaciones
        ]);
    }

    /**
    *@group Carro de compras
    *Agregar producto al carro de compras
    *
    *@response {
    *"view": "admin/mantenedores/sillas/agregar.blade.php",
    *}
    */
    public function agregarAlCarro(Request $request){
    	$idProducto = $request->idProducto;
    	$idUser = $request->idUser;
    	$usuario = User::find($idUser);
    	$itemCarro = $usuario->buscarEnCarro($idProducto)->first();
        $producto = Producto::find($idProducto);
        if($producto->activo == 0){
            return redirect()->route('productos.mostrar',$producto->clase);
        }
    	if(empty($itemCarro)){
	    	$itemCarro = Carro::create([
	    		'user_id' => $idUser,
	    		'cantidad' => 1
	    	]);
	    	$producto->enCarro()->save($itemCarro);
            if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Producto ". $producto->nombre . " agregado al carro del usuario " . $usuario->email . " con exito","completado");
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Producto ". $producto->nombre . " agregado al carro del usuario " . $usuario->email . " con exito","completado");
            }
	        return response()->json(['success'=>'guardado']);

    	}
    	elseif($itemCarro->producto_id == $idProducto){
    		$itemCarro->cantidad += 1;
    		$itemCarro->save();
            if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Se ha sumado 1 a la cantidad del producto ". $producto->nombre . " en el carro del usuario " . $usuario->email,"completado");
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Se ha sumado 1 a la cantidad del producto ". $producto->nombre . " en el carro del usuario " . $usuario->email,"completado");
            }
    		return response()->json(['success'=>'actualizado']); 
    	}
    	else{
            if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Ha ocurrido un error inesperado. Contacte al administrador del sistema","error");
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Ha ocurrido un error inesperado. Contacte al administrador del sistema","error");
            }
    		return response()->json(['success'=>'fallo']); 
    	}
    }

    /**
    *@group Carro de compras
    *Descuenta 1 de la cantidad total de un producto especifico en el carro
    *
    *@response {
    *"view": "tienda/carro",
    *}
    */
    public function modificarCantidad(Request $request){
    	try{
    		$idCarro = $request->id;
	    	$tablaProducto = $request->tipo;
	    	$operacion = $request->operacion;
	    	$itemCarro = Auth::user()->buscarEnCarro($idCarro,$tablaProducto)->first();
	    	switch ($operacion) {
	    		case 'suma':
	    			if($itemCarro->cantidad == $itemCarro->producto->cantidad){
                        if (!$request->session()->has('guest_uuid')) {
                            $request->session()->put('guest_uuid',Str::uuid());
                            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Cantidad de producto " . $itemCarro->producto->nombre . " no puede ser mayor al stock del producto.","excedemaximo");
                        }
                        else{
                            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Cantidad de producto " . $itemCarro->producto->nombre . " no puede ser mayor al stock del producto.","excedemaximo");
                        }
						return response()->json(['success'=>'excedemaximo']);
			    	}
			    	else{
	    				$itemCarro->cantidad += 1;
	    			}
	    			break;
	    		case 'resta':
	    			if($itemCarro->cantidad == 0){
                        if (!$request->session()->has('guest_uuid')) {
                            $request->session()->put('guest_uuid',Str::uuid());
                            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Cantidad de producto " . $itemCarro->producto->nombre . " no puede ser menor a 0","excedeminimo");
                        }
                        else{
                            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Cantidad de producto " . $itemCarro->producto->nombre . " no puede ser menor a 0","excedeminimo");
                        }
						return response()->json(['success'=>'excedeminimo']);
			    	}
			    	else{
	    				$itemCarro->cantidad -= 1;
	    			}
	    			break;
	    	}
	    	$itemCarro->save();
	        return response()->json(['success'=>'actualizado']);
	    }
	    catch(Throwable $e){
            if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Error desconocido. Contacte al administrador del sistema",$e->getMessage());
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Error desconocido. Contacte al administrador del sistema",$e->getMessage());
            }
	    	return response()->json(['error'=>$e->getMessage()]);
	    }
    }

    /**
    *@group Carro de compras
    *Descuenta 1 de la cantidad total de un producto especifico en el carro
    *
    *@response {
    *"view": "tienda/carro",
    *}
    */
    public function solicitaDatos(Request $request){
        $carroCompleto = Auth::user()->productosCarro();
        $regiones = Venta::getRegiones();
        $comunas = Venta::getComunas();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Formulario que solicita datos de despacho para la transaccion ","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Formulario que solicita datos de despacho para la transaccion ","completado");
        }
        return view('tienda.compra.datos',[
            'carro' => $carroCompleto,
            'regiones' => $regiones,
            'comunas' => $comunas
        ]);
    }



}
