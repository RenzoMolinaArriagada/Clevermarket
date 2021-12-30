<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Mail\Venta\ConfirmacionCompra;
use App\Jobs\SendMailCompra;
use App\Models\Personalizacion as Config;
use App\Models\Audit;
use App\Models\Clase;
use App\Models\Venta;
use App\Models\User;
use App\Models\Producto;
use App\Models\CodigoDescuento;

class VentaController extends Controller
{
    /**
    *@group Proceso de Venta
    *Verificacion del codigo de descuento
    *
    *@response {
    *"view": "tienda/carro",
    *}
    */
    public function verificarCodigoDescuento(Request $request){
        $codigoDescuento = CodigoDescuento::getCodigoIfActivo($request->codigo);
        if($codigoDescuento != NULL){
            //Codigos Privados
            if($codigoDescuento->tipo == 0 && ($codigoDescuento->usos_restantes > 0 || $codigoDescuento->usos_restantes == -1)){
                if($request->idUser != NULL){
                    $usuario = User::find($request->idUser);
                    if($usuario->id == $codigoDescuento->user_id){
                        return response()->json(['res'=>'V','desc'=>$codigoDescuento->descuento]);
                    }
                    else{
                        return response()->json(['res'=>'NA','desc'=>'Usuario no coincide']);
                    }
                }else{
                    return response()->json(['res'=>'NA','desc'=>'Usuario no logueado']);
                }
            }
            //Codigos Publicos
            elseif($codigoDescuento->tipo == 1 && ($codigoDescuento->usos_restantes > 0 || $codigoDescuento->usos_restantes == -1)){
                return response()->json(['res'=>'V','desc'=>$codigoDescuento->descuento]);
            }else{
                return response()->json(['res'=>'NA','desc'=>'Sin usos restantes']);
            }
        }
        else{
            return response()->json(['res'=>'NA','desc'=>'Codigo de descuento nulo']);
        }
        return response()->json(['failed'=>'Ha ocurrido un inconveniente.']);
    }


    /**
    *@group Proceso de venta
    *
    *
    *@response {
    *"view": "tienda/carro",
    *}
    */
    public function ingresarCompra(Request $request){
    	if(Auth::check()){         
	        $carroRaw = Auth::user()->productosCarro();
            if(isset($request->codigo_descuento)){
                $datos = $request->validate([
                'region' => ['required'],
                'comuna' => ['required'],
                'calle' => ['required'],
                'numeracion' => ['required','numeric'],
                'codigo_descuento' => ['exists:codigo_descuento,nombre']
                ]);
            }
            else{
                $datos = $request->validate([
                'region' => ['required'],
                'comuna' => ['required'],
                'calle' => ['required'],
                'numeracion' => ['required','numeric']
                 ]);
                $datos['codigo_descuento'] = NULL;
            }
            $codigoDescuento = CodigoDescuento::getCodigoIfActivo($datos['codigo_descuento']);
            if($codigoDescuento!= NULL){
                $codigoDescuento->descontar();
            };
	        $venta = new Venta();
	        $venta->user_id = Auth::user()->id;
	        $venta->estado = 1;
	        $venta->comuna_id = $datos['comuna'];
	        $venta->calle = $datos['calle'];
            $venta->numeracion = $datos['numeracion'];
            if($codigoDescuento!= NULL){
                $venta->codigo_descuento_id = $codigoDescuento->id;
            }
            else{
                $venta->codigo_descuento_id = NULL;
            }
	        $venta->save();
	        $totalProductos = 0;
	        $totalPrecio = 0;
	        foreach ($carroRaw as $itemCarro) {
	        	$precioItem = $itemCarro->cantidad * $itemCarro->producto->precio;
                $productoCarro = $itemCarro->producto;
                $productoCarro->cantidad -= $itemCarro->cantidad;
                $productoCarro->save();
	        	$venta->productos()->attach($itemCarro->producto,[
	        		'cantidad_articulos' => $itemCarro->cantidad,
	        		'precio_total' => $precioItem,
	        		'estado' => 1
	        	]);

	        	$totalProductos += $itemCarro->cantidad;
	        	$totalPrecio += $precioItem;
	        }
	        $venta->cantidad_articulos = $totalProductos;
	        $venta->precio_total = $totalPrecio;
	        $venta->save();
       		Auth::user()->desactivarCarro();
       		SendMailCompra::dispatch(Auth::user()->email,$carroRaw,$venta->precio_total);
       		if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Transaccion confirmada para el usuario " . Auth::user()->email . " con identificador ". $venta->id .".","completado");
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Transaccion confirmada para el usuario " . Auth::user()->email . " con identificador ". $venta->id .".","completado");
            }
            return view('tienda.compra.detalle',[
            	'venta' => $venta,
            	'carroCompleto' => $carroRaw
            ]);
        }
    }

   /**
    *@group Mantenedor de Ventas
     *Despacha la venta obteniendo el codigo asociado de acuerdo a la integracion con el courier seleccionado
     *
     *@response {
     *"view": "admin/mantenedores/sillas.blade.php",
     *}
    */
    public function ventaDespachar(Request $request){
        $venta = Venta::find($request->venta);
        $venta->estado = 2;
        $venta->courier_id = $request->courier;
        if($venta->courier->nombre == 'Chilexpress'){
            $subscriptionKeyCob = $venta->courier->client_secret;
            $codigoChilexpress = $venta->comuna->region->codigo_chilexpress;
            $countyComprador = IntegracionesController::getCountyChilexpress($subscriptionKeyCob,$codigoChilexpress,$venta->comuna);
            $tienda = Config::find(1);
            $tiendaCodChilexpress = $tienda->comuna->region->codigo_chilexpress;
            $countyDevolucion = IntegracionesController::getCountyChilexpress($subscriptionKeyCob,$tiendaCodChilexpress,$tienda->comuna);
        }
        $venta->save();
        return redirect()->route('admin.manVentas');
    }

    /**
    *@group Mantenedor de Ventas
    *Descuenta 1 de la cantidad total de un producto especifico en el carro
    *
    *@response {
    *"view": "tienda/carro",
    *}
    */
    public function ventaRecibido(Request $request, User $usuario){
    	$venta = Venta::find($request->venta);
    	$venta->estado = 3;
    	$venta->save();
    	return redirect()->route('user.perfil',$usuario);
    }

    public function ventasPorMes(Request $request){
        $clases = Clase::all();
        $ventasPorMes = Venta::ventasPorMes($request->anoVentas);
        $nombreClases = [];
        $cantidadClases = [];
        $ventasPorClase = Venta::ventasPorClase($clases,$request->anoVentas);
        foreach($ventasPorClase as $ventas){
            $nombreClases[] = $ventas['nombre'];
            $cantidadClases[] = $ventas['ventaClase'];  
        }
        return response()->json(['ventasPorMes'=>$ventasPorMes,'nombreClases'=>$nombreClases,'cantidadClases'=>$cantidadClases]); 
    }
}
