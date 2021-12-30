<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:16|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[.!@%^&*-]).{9,}$/',
        ],[
            'email.unique' => 'El correo ya está en uso.',
            'password.regex' => 'La contraseña debe contener al menos una mayuscula, una minuscula, un numero y un caracter especial (.!@%^&*-).' 
        ]);
        $url_array = explode(" ",$request->name);
        $url = '';
        foreach ($url_array as $url_part) {
            $url = $url . $url_part;
        }
        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'url' => $url
        ]));

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
