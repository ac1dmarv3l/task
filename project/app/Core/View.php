<?php

declare(strict_types=1);

namespace App\Core;

final class View
{
    /**
     * @param string $view
     * @param array $params
     * @return never
     */
    public static function render(string $view, array $params = []): never
    {
        extract($params);

        if (file_exists(ROOT_PATH . 'app/View/' . $view . '.php')) {
            require_once ROOT_PATH . 'app/View/' . $view . '.php';
        }

        exit;
    }

    /**
     * @return never
     */
    public static function redirectToHomepage(): never
    {
        http_response_code(404);

        header('location: /');

        exit;
    }

    /**
     * @param string $path
     * @return never
     */
    public static function redirectTo(string $path): never
    {
        http_response_code(302);

        header('location: ' . $path);

        exit;
    }
}
