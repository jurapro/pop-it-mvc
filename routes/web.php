<?php

use Src\Route;

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/go/{message}', [Controller\Site::class, 'index']);
    $r->addRoute('GET', '/hello', [Controller\Site::class, 'hello']);
});

Route::setDispatcher($dispatcher);