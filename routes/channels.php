<?php

use Illuminate\Support\Facades\Broadcast;
use \App\Models\Chat;
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

Broadcast::channel('chat.{id}', function($user, $id) {
    $result = Chat::where('id', '=', (int)$id)->whereHas('users', function ($q) use ($user) {
        $q->where('userId', (int)$user->id);
    })->first();

    //dd($result);

    if ($result) {
        return $user;
    }
});

Broadcast::channel('users-online', function ($user) {
    if(\Illuminate\Support\Facades\Auth::check()){
        return new \App\Http\Resources\Api\Contacts\ContactsResource($user);
    }
});

