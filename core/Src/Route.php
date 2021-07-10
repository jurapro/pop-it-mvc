<?php

namespace Src;

use Error;

use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use FastRoute\DataGenerator\MarkBased;
use FastRoute\Dispatcher\MarkBased as Dispatcher;

class Route
{
    private static RouteCollector $routeCollector;

    private string $prefix = '';
    private Dispatcher $dispatcher;

    public static function add($httpMethod, string $route, array $action): void
    {
        if (!isset(self::$routeCollector)) {
            self::$routeCollector = new RouteCollector(new Std(), new MarkBased());
        }
        self::$routeCollector->addRoute($httpMethod, $route, $action);
    }

    public static function group(string $prefix, callable $callback): void
    {
        if (!isset(self::$routeCollector)) {
            self::$routeCollector = new RouteCollector(new Std(), new MarkBased());
        }
        self::$routeCollector->addGroup($prefix, $callback);
    }

    public function redirect(string $url): void
    {
        header('Location: ' . $this->getUrl($url));
    }

    public function getUrl(string $url): string
    {
        return $this->prefix . $url;
    }

    public function __construct(string $prefix = '')
    {
        $this->setPrefix($prefix);
        $this->setDispatcher();
    }

    public function setDispatcher(): void
    {
        if (!isset(self::$routeCollector)) {
            throw new Error('ROUTE_NOT_FOUND');
        }
        $loader = self::$routeCollector->getData();
        $this->dispatcher = new Dispatcher($loader);
    }

    public function setPrefix(string $value = ''): void
    {
        $this->prefix = $value;
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
        $uri = substr($uri, strlen($this->prefix));

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new Error('NOT_FOUND');
            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new Error('METHOD_NOT_ALLOWED');
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = array_values($routeInfo[2]);
                $vars[] = new Request();
                $class = $handler[0];
                $action = $handler[1];
                call_user_func([new $class, $action], ...$vars);
                break;
        }
    }
}