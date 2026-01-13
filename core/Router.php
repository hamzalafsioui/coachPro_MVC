<?php

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => [],
        'OPTIONS' => [],
    ];

    private function addRoute(string $method, string $path, $handler): self
    {
        $method = strtoupper($method);
        $path = '/' . trim($path, '/');
        if ($path === '//') {
            $path = '/';
        }

        $this->routes[$method][] = [
            'path' => $path,
            'handler' => $handler,
        ];

        return $this;
    }
}
