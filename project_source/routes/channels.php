<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

//Broadcast::channel('be-dormitory-channel2', function () {
//    return true; // hoặc điều kiện để xác thực người dùng
//});

Broadcast::channel('privateNotification.{objectId}', function ($user, $objectId) {
//    return (int) $user->id === (int) $objectId;
    return true;
});

