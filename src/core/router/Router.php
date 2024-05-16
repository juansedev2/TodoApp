<?php
namespace Jdev2\TodoApp\core\router;

use Exception;
use Jdev2\TodoApp\app\controllers\ExceptionController;

class Router{

    public function __construct(private array $routes){}

    /**
     * This function handle the request, get the URI and handle the correct action according the route (see the routes)
    */
    public function handle(string $route){
        
        // First evaluare the string request and comparate it with the existing routes
        if(array_key_exists($route, $this->routes)){
            
            $route = $this->routes[$route];
            $class = $route[0];
            $method = $route[1];
            $class = "Jdev2\\TodoApp\\app\\controllers\\{$class}";

            if(!class_exists($class)){
                throw new Exception("Error, the controller {$class} doesn't no exist!", 1);
            }

            if(!method_exists($class, $method)){
                throw new Exception("Error, the mehtod {$method} of the controller {$class} doesn't no exist!", 1);
            }
            
            return (new $class())->$method();
        }

        return ExceptionController::returnNotFoundView();
        
        //throw new Exception("Error, that route doesn't no exist: {$route}!", 1);
        
    }
}