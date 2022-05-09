<?php
namespace Src\Routes;

use CoffeeCode\Router\Router;

class Requests
{

    public function __construct()
    {
        $this->Router();
        
    }

    public function Router()
    {
        
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
        }

    }
}