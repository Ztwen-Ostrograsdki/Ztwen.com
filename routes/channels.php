<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('master', function ($user) {
    return (int) $user->id === 1 || $user->role === 'master';
});
Broadcast::channel('online', function ($user) {
    if((int) $user->id === (int) auth()->user()->id){
        return ['id' => $user->id, 'name' => $user->name, 'email' => $user->email];
    }
});
