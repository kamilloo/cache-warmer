<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
use Snowdog\DevTest\Component\Menu;
use Snowdog\DevTest\Component\RouteRepository;

session_start();

$container = require __DIR__ . '/../app/bootstrap.php';

$routeRepository = RouteRepository::getInstance();

$dispatcher = \FastRoute\simpleDispatcher($routeRepository);

Menu::setContainer($container);

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/../src/view/404.phtml';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        header("HTTP/1.0 405 Method Not Allowed");
        require __DIR__ . '/../src/view/405.phtml';
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];
        $container->call($controller, $parameters);
        break;
}
