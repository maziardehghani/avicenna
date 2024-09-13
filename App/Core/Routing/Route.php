<?php

namespace App\Core\Routing;

class Route
{
    private static array $routes = [];

    public static function addRoute($methods,$uri,$action = null, $middleware = [])
    {
        $methods = is_array($methods) ? $methods : [$methods];

        self::$routes[] = ['methods' => $methods,'uri' => $uri,'action' => $action, 'middleware' => $middleware];
    }

    public static function get($uri,$action = null, $middleware = [])
    {
        self::addRoute('get',$uri,$action, $middleware);
    }
    public static function post($uri,$action = null, $middleware = [])
    {
        self::addRoute('post',$uri,$action, $middleware);
    }
    public static function put($uri,$action = null, $middleware = [])
    {
        self::addRoute('put',$uri,$action, $middleware);
    }

    public static function delete($uri,$action = null, $middleware = [])
    {
        self::addRoute('delete',$uri,$action, $middleware);
    }

    public static function routes()
    {
        return static::$routes;
    }

}