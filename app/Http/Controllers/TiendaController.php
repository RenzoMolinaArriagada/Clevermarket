<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Clase;
use Illuminate\Support\Str;
use App\Models\Audit;

class TiendaController extends Controller
{
    public function mostrarProductos(Request $request,Clase $clase){
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra la lista de productos de la clase " . $clase->nombre .".","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra la lista de productos de la clase " . $clase->nombre .".","completado");
        }
        if($clase->activo == 1){
            return view('tienda.menu',[
                'productos' => Producto::activosPorClase($clase)
            ]);
        }
        else{
            return redirect()->route('home');
        }
    }

    public function vistaProducto(Request $request,Clase $clase,Producto $producto){
        if($producto->activo == 0){
            return redirect()->route('productos.mostrar',$clase);
        }
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el producto " . $producto->nombre . " y sus caracteristicas.","completado");
            
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el producto " . $producto->nombre . " y sus caracteristicas.","completado");
        }
        VistoController::guardarVisualizacion($request,$producto);
        if($clase->activo == 1 && $producto->activo == 1){
            return view('tienda.productos',[
                'producto' => $producto
            ]);
        }
        elseif ($producto->activo == 0 && $clase->activo == 1) {
            return redirect()->route('productos.mostrar',$clase);
        }
        else{
            return redirect()->route('home');
        }
        
    }

}
