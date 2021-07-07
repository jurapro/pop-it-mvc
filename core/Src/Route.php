<?php

namespace Src;

use Error;

class Route
{
    private static array $routes = [];
    private static string $prefix = '';
    private static $dispatcher;

    public static function setDispatcher($dispatcher)
    {
        self::$dispatcher = $dispatcher;
    }

    public static function setPrefix(string $value)
    {
        self::$prefix = $value;
    }

    public static function add(string $route, array $action): void
    {
        if (!array_key_exists($route, self::$routes)) {
            self::$routes[$route] = $action;
        }
    }

    public function start(): void
    {
        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        $uri = substr($uri, strlen(self::$prefix));

        $routeInfo = self::$dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                throw new Error('NOT_FOUND');
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                throw new Error('METHOD_NOT_ALLOWED');
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                $class = $handler[0];
                $action = $handler[1];
                call_user_func([new $class, $action], ...$vars);
                break;
        }

    }
}