<?php

class Router {
    protected $routes = [];

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve() {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }

        // Remove base path if running in subdirectory
        $basePath = '/algoritma-sitesi';
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }
        
        if ($path == '') {
            $path = '/';
        }

        $method = $_SERVER['REQUEST_METHOD'];
        
        // Check for exact match first
        if (isset($this->routes[$method][$path])) {
            $callback = $this->routes[$method][$path];
            $this->executeCallback($callback);
            return;
        }

        // Check for dynamic routes
        foreach ($this->routes[$method] as $route => $callback) {
            // Convert route to regex (e.g., /problem/{slug} -> /problem/([^/]+))
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";
            
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Remove full match
                $this->executeCallback($callback, $matches);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    private function executeCallback($callback, $params = []) {
        if (is_string($callback)) {
            $parts = explode('@', $callback);
            $controllerName = $parts[0];
            $methodName = $parts[1];

            require_once __DIR__ . "/../app/Controllers/$controllerName.php";
            $controller = new $controllerName();
            call_user_func_array([$controller, $methodName], $params);
        } else {
            call_user_func_array($callback, $params);
        }
    }
}
