<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestPath = str_replace('/closet_fashion', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if (empty($requestPath)) {
            $requestPath = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestPath) {
                call_user_func($route['handler']);
                return;
            }
        }

        // Página não encontrada
        http_response_code(404);
        echo "Página não encontrada";
    }
}

