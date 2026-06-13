<?php

class Router
{
    private array $routes = [];

    public function get(string $path, string $handler): void
    {
        $this->routes[] = ['GET', $path, $handler];
    }

    public function post(string $path, string $handler): void
    {
        $this->routes[] = ['POST', $path, $handler];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as [$routeMethod, $routePath, $handler]) {
            if ($method !== $routeMethod) {
                continue;
            }

            $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $routePath);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                [$controllerName, $methodName] = explode('@', $handler);
                $controller = new $controllerName();
                call_user_func_array([$controller, $methodName], $matches);
                return;
            }
        }

        http_response_code(404);
        echo '<h1 style="font-family:sans-serif;padding:2rem">404 – Página não encontrada</h1>';
    }
}
