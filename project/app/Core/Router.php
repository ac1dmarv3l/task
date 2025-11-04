<?php

declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = require(ROOT_PATH . '/config/routes.php');
    }

    /**
     * @param string $path
     * @param string $method
     * @return ?array
     */
    private function match(string $path, string $method): ?array
    {
        if (isset($this->routes[$path][$method])) {
            return $this->routes[$path][$method];
        }

        return null;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = trim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');
        $query = parse_url($_SERVER['REQUEST_URI'])['query'] ?? '';

        $params = [];

        parse_str($query, $params);

        $route = $this->match($path, $method);

        if ($route) {
            $controllerClass = $route['controller'];

            if (!class_exists($controllerClass)) {
                View::redirectToHomepage();
            }

            $dependencies = [];

            if (isset($route['dependencies'])) {
                foreach ($route['dependencies'] as $dependency) {
                    $dependencies[] = new $dependency(Database::getInstance());
                }
            }

            $controller = new $controllerClass(...$dependencies);

            if (method_exists($controller, $route['action'])) {
                $controller->{$route['action']}($params);
            }

        } else {
            View::redirectToHomepage();
        }
    }
}
