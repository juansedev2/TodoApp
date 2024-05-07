<?php
require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/src/core/Bootstrap.php";
use Jdev2\TodoApp\core\router\Router;
use Jdev2\TodoApp\core\router\Handler;
$router = new Router(require __DIR__ . "/src/core/router/Routes.php");
$router->handle(Handler::handleRequest());