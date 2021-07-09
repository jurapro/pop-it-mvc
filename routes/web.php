<?php

use Src\Route;

Route::group('/go', function () {
    Route::add('GET', '/', [Controller\Site::class, 'index']);
    Route::add('GET', '/hello', [Controller\Site::class, 'hello']);
    Route::add(['GET','POST'], '/signup', [Controller\Site::class, 'signup']);
});
