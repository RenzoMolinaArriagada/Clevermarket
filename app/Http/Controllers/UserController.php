<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Audit;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function perfil(Request $request,User $usuario){
        $compras = $usuario->getCompras();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el perfil del usuario.","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el perfil del usuario.","completado");
        }
    	return view('user.perfil',[
    		'usuario' => $usuario,
            'compras' => $compras
    	]);
    }

    public function formEditPerfil(Request $request, User $usuario){
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para editar el perfil.","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para editar el perfil.","completado");
        }
    	return view('user.perfil.editar',[
    		'usuario' => $usuario
    	]);
    }

}
