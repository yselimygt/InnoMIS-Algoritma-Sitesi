<?php

class Router
{
    protected $routes = [];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');

        if ($position !== false) {
            $path = substr($path, 0, $position);
        }

        // Normalize path and remove base path if running in subdirectory
        $scriptName = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        if ($scriptName !== '' && strpos($path, $scriptName) === 0) {
            $path = substr($path, strlen($scriptName));
        }

        // Ensure path uses a canonical form (starts with '/', no trailing slash except root)
        $path = '/' . trim($path, '/');
        if ($path === '/') {
            // keep as root
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

    private function executeCallback($callback, $params = [])
    {
        if (is_string($callback)) {
            $parts = explode('@', $callback);
            $controllerName = $parts[0];
            $methodName = $parts[1];

            $controllerFile = __DIR__ . "/../app/Controllers/$controllerName.php";
            if (!file_exists($controllerFile)) {
                http_response_code(500);
                echo "Controller file for $controllerName not found.";
                return;
            }

            require_once $controllerFile;

            if (!class_exists($controllerName)) {
                http_response_code(500);
                echo "Controller class $controllerName not found.";
                return;
            }

            $controller = new $controllerName();
            if (!method_exists($controller, $methodName) || !is_callable([$controller, $methodName])) {
                http_response_code(500);
                echo "Method $methodName not found in controller $controllerName.";
                return;
            }

            call_user_func_array([$controller, $methodName], $params);
        } else {
            call_user_func_array($callback, $params);
        }
    }
}
