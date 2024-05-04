<?php

class Router{

    public function __construct(private array $routes){}

    /**
     * This function handle the request, get the URI and handle the correct action according the route (see the routes)
    */
    public function handle(string $route){
        
        // First evaluare the string request and comparate it with the existing routes
        if(array_key_exists($route, $this->routes)){
            return require Injector::get("app-route"). "/app/" . $this->routes[$route];
        }

        throw new Exception("Error, that route doesn't no exist!", 1);
        
    }
}