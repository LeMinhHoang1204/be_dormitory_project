<?php

use Illuminate\Support\Facades\Broadcast;

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

//Broadcast::channel('notification-channel', function ($user) {
//    return true; // You can add authorization logic here if needed
//});
