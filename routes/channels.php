<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('chat.room', function ($user, $roomId) {
    // ✅ Customize your room access logic here
    return true; // or check if user is part of room
});
