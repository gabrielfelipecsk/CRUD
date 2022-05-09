<?php
/**
 * Composer
 */
require __DIR__.'/vendor/autoload.php';

/**
 * Configuration
 */
/**
 * Headers for CORS 
 */
require __DIR__.'/src/Core/Headers.php';

/**
 * Use the application
 */
use CoffeeCode\Router\Dispatch;
use Src\Core\DBConnection;
use CoffeeCode\Router\Router;
\Src\Core\Environment::loadEnv(__DIR__);


/**
 * Router
 */
$router = new Router(getenv('BASE_URL'));

/**
 * Controllers
 */
$router->namespace("Src\Controllers");
/**
 *  GET
 */
$router->get("/", "Route:index");

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
$router->post("/update", "Route:profileUpdate");

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

