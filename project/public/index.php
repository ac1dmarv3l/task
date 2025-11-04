<?php

use App\Core\Router;

const ROOT_PATH = __DIR__ . '/../';

require_once ROOT_PATH . 'vendor/autoload.php';

session_start();

new Router()->run();
