<?php
/**
 * Composer
 */
require __DIR__.'/vendor/autoload.php';

/**
 * Configuration
 */
/**
 * Use the application
 */
use Src\Controllers\Api;
use CoffeeCode\Router\Dispatch;
use Src\Core\DBConnection;
use CoffeeCode\Router\Router;


new Api(__DIR__);

/**
 * Router
 */
$router = new Router(getenv('BASE_URL'));

/**
 * Controllers
 */
$router->namespace("Src\Controllers");
/**
 * POST 
 */
$router->post("/login", "Auth:login");
$router->post("/register", "Auth:register");
$router->post("/logout", "Auth:logout");
$router->post("/forgot", "Auth:forgot");

$router->group('/dashboard');


$router->group('/profile');
$router->get("/", "Route:profile");
$router->put("/", "Route:profileUpdate");
$router->delete("/", "Route:profileDelete");


/**
 * RENDER
 */
$router->dispatch();

/**
 * ERRORS
 */
if ($router->error()) {
    echo json_encode(["error" => $router->error()], true);
    header("HTTP/1.1 404 Not Found");
}

