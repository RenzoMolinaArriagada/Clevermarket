<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Audit;
use App\Models\User;
use App\Models\CodigoDescuento;

class FidelizacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function manCodigosDescuento(Request $request){
        $codigos = CodigoDescuento::activos();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra la pagina de los códigos de descuento","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra la pagina de los códigos de descuento","completado");
        }
        return view('admin.fidelizacion.codigos_descuento.main',[
            'codigos' => $codigos
        ]);
    }

    public function formCreateCodigoDescuento(Request $request){
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario de creacion para los códigos de descuento","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario de creacion para los códigos de descuento","completado");
        }
        return view('admin.fidelizacion.codigos_descuento.agregar');
    }

    public function createCodigoDescuento(Request $request){
        $datos = $request->validate([
            'nombre' => ['required','min:4','unique:App\Models\CodigoDescuento,nombre'],
            'descuento' => ['required','numeric'],
            'fechaCad' => ['required','date'],
            'usosRestantes' => ['required','numeric'],
            'tipo' => ['required','numeric'],
            'email_descuento' => ['required_if:tipo,0','exists:users,email']
        ],[
            'usosRestantes.required' => 'Debe ingresar una cantidad de usos.',
            'usosRestantes.numeric' => 'La cantidad de usos debe ser un numero.',
            'fechaCad.required' => 'Debe ingresar una fecha de caducidad para el código de descuento.',
            'email_descuento.required_if' => 'Debe ingresar el correo del usuario al que otorgará el código de descuento.',
            'email_descuento.exists' => 'El mail debe ser de un usuario existente.'
        ]);
        if(isset($datos['email_descuento'])){
            $propietario = User::getPorEmail($datos['email_descuento']);
            $codigo = CodigoDescuento::create([
            'nombre' => $datos['nombre'],
            'descuento' => $datos['descuento'],
            'usos_restantes' => $datos['usosRestantes'],
            'tipo' => $datos['tipo'],
            'activo_hasta' => $datos['fechaCad'],
            'user_id' => $propietario->id
            ]);
        }else{
            $codigo = CodigoDescuento::create([
            'nombre' => $datos['nombre'],
            'descuento' => $datos['descuento'],
            'usos_restantes' => $datos['usosRestantes'],
            'tipo' => $datos['tipo'],
            'activo_hasta' => $datos['fechaCad']
            ]);
        }
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Código de descuento ". $codigo->nombre ." creado con exito","create");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Código de descuento ". $codigo->nombre ." creado con exito","create");
        }
        return redirect()->route('fid.manCodigosDescuento')->with('exito','¡Código de descuento creado con exito!');
    }

    public function formEditCodigoDescuento(Request $request, CodigoDescuento $codigo){
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario de edición para los códigos de descuento","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario de edición para los códigos de descuento","completado");
        }
        return view('admin.fidelizacion.codigos_descuento.editar',[
            'codigo' => $codigo
        ]);
    }

    public function editCodigoDescuento(Request $request, CodigoDescuento $codigo){
        $datos = $request->validate([
            'nombre' => ['required','min:4','unique:App\Models\CodigoDescuento,nombre'],
            'descuento' => ['required','numeric'],
            'fechaCad' => ['required','date'],
            'usosRestantes' => ['required','numeric'],
            'tipo' => ['required','numeric'],
            'email_descuento' => ['required_if:tipo,0','exists:users,email'],
        ],[
            'usosRestantes.required' => 'Debe ingresar una cantidad de usos.',
            'usosRestantes.numeric' => 'La cantidad de usos debe ser un numero.',
            'fechaCad.required' => 'Debe ingresar una fecha de caducidad para el código de descuento.',
            'email_descuento.required_if' => 'Debe ingresar el correo del usuario al que otorgará el código de descuento.',
            'email_descuento.exists' => 'El mail debe ser de un usuario existente.'
        ]);
        if(isset($datos['email_descuento'])){
            $propietario = User::getPorEmail($datos['email_descuento']);
            $codigo->update([
            'nombre' => $datos['nombre'],
            'descuento' => $datos['descuento'],
            'usos_restantes' => $datos['usosRestantes'],
            'tipo' => $datos['tipo'],
            'activo_hasta' => $datos['fechaCad'],
            'user_id' => $propietario->id
            ]);
        }else{
            $codigo->update([
            'nombre' => $datos['nombre'],
            'descuento' => $datos['descuento'],
            'usos_restantes' => $datos['usosRestantes'],
            'tipo' => $datos['tipo'],
            'activo_hasta' => $datos['fechaCad']
            ]);
        }
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Código de descuento ". $codigo->nombre ." actualizado con exito","create");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Código de descuento ". $codigo->nombre ." actualizado con exito","create");
        }
        return redirect()->route('fid.manCodigosDescuento')->with('exito','¡Código de descuento actualizado con exito!');
    }
}
