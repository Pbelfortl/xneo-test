<?php

    declare (strict_types=1);
    require "vendor/autoload.php";

    header("Access-Control-Allow-Headers: Authorization, Content-Type");
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS, DELETE');
    header('content-type: application/json; charset=utf-8');

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $database = new Database ($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);

    $tasks_repository = new TaskRepository($database);

    $controller = new TaskController($tasks_repository);

    $controller -> processRequest($_SERVER["REQUEST_METHOD"]);