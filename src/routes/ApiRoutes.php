<?php
namespace App\routes;

use FastRoute\RouteCollector;
use App\Services\HealthService;
use App\Services\MovementService;

class ApiRoutes
{
    public static function register(RouteCollector $r)
    {
        // Movement
        $r->addRoute('GET', '/movement/{movement}', [MovementService::class, 'handle']);

        // Movement
        $r->addRoute('GET', '/movement/full/{movement}', [MovementService::class, 'handleFull']);

        // Health check
        $r->addRoute('GET', '/health', [HealthService::class, 'handle']);
    }
}
