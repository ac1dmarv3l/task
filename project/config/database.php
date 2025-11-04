<?php

return [
    'host' => $_ENV['POSTGRES_HOST'],
    'port' => $_ENV['POSTGRES_PORT'],
    'dbname' => $_ENV['POSTGRES_DB'],
    'username' => $_ENV['POSTGRES_USER'],
    'password' => $_ENV['POSTGRES_PASSWORD'],
];