<?php

declare(strict_types=1);

// Configuração definindo utc e json de resposta
date_default_timezone_set('UTC');

require_once dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

use App\routes\ApiRoutes;
use FastRoute\RouteCollector;

$dispatcher = \FastRoute\simpleDispatcher(function(RouteCollector $r) {
    ApiRoutes::register($r);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
    case \FastRoute\Dispatcher::FOUND:
        [$class, $method] = $routeInfo[1];
        $vars = $routeInfo[2];
        $controller = new $class();
        try {
            $controller->$method($vars);
        } catch (\Throwable $e) {
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(500);
            echo json_encode([
                'error' => 'Erro interno',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
        break;
}

