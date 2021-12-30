<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Audit;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Sesion iniciada con exito en el portal.","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Sesion iniciada con exito en el portal.","completado");
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Handle an incoming authentication request via ajax.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAjax(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Sesion iniciada con exito en el portal.","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Sesion iniciada con exito en el portal.","completado");
        }
        return redirect()->back();
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),__METHOD__,"completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),__METHOD__,"completado");
        }
        return redirect('/');
    }
}
