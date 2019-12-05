<?php

namespace simonardejr\Router;

use simonardejr\Router\Request;

class Router
{
    protected static $routes = [];

    public static function run()
    {
        Router::init()->direct( Request::uri(), Request::method() );
    }

    public static function init()
    {
        $router = new static;

        return $router;
    }

    public static function get($uri, $callback)
    {
        static::$routes['GET'][$uri] = $callback;
    }

    public static function post($uri, $callback)
    {
        static::$routes['POST'][$uri] = $callback;
    }

    public function direct($uri, $requestType)
    {
        $callback = $this->getCallback($uri, $requestType);

        if ( array_key_exists($uri, static::$routes[$requestType]) ) {
            if ( $this->isClosure($callback) ) {
                return $this->callUserFunc($callback);
            }

            return $this->callController(...explode('@', $callback));
        }
    }

    public function getCallback($uri, $requestType)
    {
        return static::$routes[$requestType][$uri] ?? false;
    }

    public static function isClosure($callback) {
        return $callback instanceof \Closure;
    }

    public function callUserFunc($callback)
    {
        if ( is_callable($callback) ) {
            return call_user_func($callback);
        }

        return $callback();
    }

    public function callController($controller, $action)
    {
        require __DIR__ . '/../../controllers/' . $controller . '.php';
        $controller = new $controller;

        if ( ! method_exists($controller, $action) ) {
            throw new \Exception("{$controller} does not respond to the 
                {$action} action.");
        }

        return $controller->$action();
    }
}
