<?php

use Illuminate\Support\Facades\Broadcast;

//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    //return (int) $user->id === (int) $id;
//});

Broadcast::routes();
Broadcast::channel('turnos', fn() => true);

Broadcast::channel('turnos', function () {
    \Log::info("ALGUIEN SE SUSCRIBIÓ AL CANAL TURNOS");
    return true;
});
