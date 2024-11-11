<?php

use Illuminate\Support\Facades\Broadcast;

//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});

Broadcast::channel('be-dormitory-channel', function () {
    return true; // hoặc điều kiện để xác thực người dùng
});

