<?php
namespace Src\Controllers;

use CoffeeCode\Router\Router;

class Requests
{

    public function Router()
    {
        
        /**
         * Router
         */
        $base = getenv('BASE_URL');
        $router = new Router($base);
    

        /**
         * Controllers
         */
        $router->namespace("Src\Controllers");
        $router->post("/entrar", "Auth:login");
        $router->post("/registrar", "Auth:register");
        $router->post("/recuperar", "Auth:forgot");
        $router->get("/sair", "Auth:logout");

        $router->group('/dashboard');
        $router->get("/", "Dashboard:index");

        
        $router->group('/perfil');
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