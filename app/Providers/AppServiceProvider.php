<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Clase;
use App\Models\Personalizacion;
use App\Models\Integraciones;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $clases = Clase::activos();
        $personalizacion = Personalizacion::find(1);
        View::share('clases',$clases);
        View::share('personalizacion',$personalizacion);
    }
}
