<?php

namespace Src;

use Error;

class Route
{
    private static array $routes = [];
    private static string $prefix = '';

    public static function setPrefix($value)
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
        $path = explode('?', $_SERVER['REQUEST_URI'])[0];
        $path = substr($path, strlen(self::$prefix) + 1);

        if (!array_key_exists($path, self::$routes)) {
            throw new Error('This path does not exist');
        }

        if (!class_exists(self::$routes[$path][0])) {
            throw new Error('This class does not exist');
        }

        if (!method_exists(self::$routes[$path][0], self::$routes[$path][1])) {
            throw new Error('This method does not exist');
        }

        $class = new self::$routes[$path][0];
        $action = self::$routes[$path][1];
        call_user_func([$class, $action]);
    }
}