<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('api.info');
});

//Route::get('/test', function () {
//    dump('222');
//});
