<?php
namespace App\Core;
class Requests
{

    private $params;
    private $methods;
    private $agent;
    private $ip;
    private $uri;
    private array $routeParams;
    public function __construct()
    {
        $this->params = $_REQUEST;
        $this->agent = $_SERVER['HTTP_USER_AGENT'];
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->methods = strtolower($_SERVER['REQUEST_METHOD']);
        $this->uri = str_replace($_ENV['SUBDOMAIN'], '', strtok($_SERVER['REQUEST_URI'],'?'));
    }

    public function methods()
    {
        return $this->methods;
    }

    public function params()
    {
        return $this->params;
    }

    public function agent()
    {
        return $this->agent;
    }

    public function ip()
    {
        return $this->ip;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function input($key)
    {
        return $this->params[$key] ?? null;
    }

    public function isset($key): bool
    {
        return isset($this->params[$key]);
    }

    public function redirect(string $url)
    {
        header("Location: " . siteUrl($url));
        die();
    }

    public function addRouteParam($key,$value)
    {
        $this->routeParams[$key] = $value;
    }

    public function getRouteParam($key)
    {
        return $this->routeParams[$key];
    }

    public function getAllParams()
    {
        return $this->routeParams;
    }
}