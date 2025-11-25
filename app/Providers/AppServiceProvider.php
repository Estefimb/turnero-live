<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        
        // ** CONFIGURACIÓN PARA EL CORREO DE SATISFACCIÓN **
        // Cuando el evento 'TurnoActualizado' es disparado...
        \App\Events\TurnoActualizado::class => [
            // ...se ejecuta este Listener para enviar el correo si el turno está finalizado.
            \App\Listeners\SendSatisfactionSurvey::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    
}
