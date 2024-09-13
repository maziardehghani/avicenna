<?php

namespace App\Core\Routing;

use App\Core\Requests;

class Router
{
    private $request;
    private $routes;
    private $currentRoute;

    const BASECONTROLLER = 'App\Controller\\';

    public function __construct()
    {

        $this->request = new Requests();
        $this->routes = Route::routes();
        $this->currentRoute = $this->findRoute($this->request) ?? null;

        $this->dispatchMiddleware($this->currentRoute);

    }

    public function dispatchMiddleware($route)
    {
        $middlewares = $route['middleware'];
        foreach ($middlewares as $middleware) {

            $middlewareObj = new $middleware();
            $middlewareObj->handle();
        }

    }
    public function findRoute(Requests $request)
    {

        foreach ($this->routes as $route) {
            if (!in_array($request->methods(), $route['methods'])) {
                return false;
            }
            if ($this->regexMatch($route)) {

                return $route;
            }
        }

        return null;
    }

    private function regexMatch($route)
    {
        global $request;

        $pattern = "/^". str_replace(['/','{','}'],['\/','(?<','>[-%\w]+)'],$route['uri'])."$/";
        $result = preg_match($pattern, $this->request->uri(), $matches);
        if(!$result)
        {
            return false;
        }
        foreach ($matches as $key => $value)
        {
            if (!is_int($value))
            {
                $request->addRouteParam($key, $value);
            }
        }
        return true;
    }
    public function run()
    {
        $this->dispatch($this->currentRoute);
    }

    public function dispatch($route)
    {
        $action = $route['action'];

        if (is_callable($action))
        {
            $action();
        }

        if (is_array($action)){
            $classname = self::BASECONTROLLER . $action[0];
            $method = $action[1];

            if (!class_exists($classname)) {
                throw new \Exception("Class $classname does not exist");
            }

            $controller = new $classname();

            if (!method_exists($controller, $method)) {
                throw new \Exception("Method $method() does not exist");
            }

            $controller->{$method}();

        }
    }
}