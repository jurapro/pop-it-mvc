<?php

use Src\Route;

Route::group('/go', function () {
    Route::add('GET', '/', [Controller\Site::class, 'index'])
        ->middleware('auth', 'can:user|admin');
    Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
    Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
    Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
});
