<?php

namespace App\Providers;

use App\Models\OpcionMenu;
use Carbon\Carbon;
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
        view()->composer('theme.lte.aside', function ($view) {
            $opciones = OpcionMenu::getMenu();
            $view->with('opciones', $opciones);
        });
        view()->share('theme', 'lte');
        // Configuración para fechas en español
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');
    }
}
