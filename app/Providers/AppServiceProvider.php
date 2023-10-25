<?php

namespace App\Providers;

use App\Models\seguridad\Funcion;
use App\Models\seguridad\Modulo;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer(['layouts.sidebar'], function($view){
            $view->with('menu', (new Modulo)->menu());
        });

        View::composer(['layouts.botones'], function($view){
            $view->with('funcion', Funcion::where('boton', true)->orderBy('orden')->get());
        });
    }
}
