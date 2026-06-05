<?php

namespace App\Providers;
//Service Provider este locul central unde se face "legatura" intre aplicatie si diverse servicii, sau unde setezi reguli globale inainte ca aplicatia sa primeasca o
// cerere de la un utilizator. Este practic locul unde se configureaza "motorul" aplicatiei la pornire.
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    //Aceasta metoda se executa prima, inainte ca aplicatia sa fie pornita complet.
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    //Aceasta metoda se executa dupa ce toate celelalte componente din Laravel au fost inregistrate.
    public function boot(): void
    {
        // Verificam daca aplicatia ruleaza pe serverul oficial de productie (live).
        if (config('app.env') === 'production' || env('APP_ENV') === 'production') {
            // Fortam Laravel sa genereze toate link-urile, rutele si scripturile folosind HTTPS (conexiune securizata).
            \URL::forceScheme('https');
        }
    }
}
