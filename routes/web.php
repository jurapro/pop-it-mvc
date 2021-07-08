<?php

use Src\Route;

Route::group('/site', function () {
    Route::add('GET', '/', [Controller\Site::class, 'index']);
    Route::add('GET', '/hello', [Controller\Site::class, 'hello']);
});
