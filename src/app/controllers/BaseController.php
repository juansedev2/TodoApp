<?php
namespace Jdev2\TodoApp\app\controllers;

use Jdev2\TodoApp\core\Injector;
use Jdev2\TodoApp\core\helpers\SessionValidator;

class BaseController{

    /**
     * This function returns the specific name of view and existing data that the values can need it
     * @param string $view is the name of the view to return (only the name without extension)
     * @param array $params is the associative array to the data to will be show in the view (this data requires will be stored in an associative array to his extraction)
    */
    public static function returnView(string $view, Array $params = []){
        extract($params);
        require Injector::get("app-route") . "/public/views/" . $view . ".view.php";
    }
    /**
     * This function redirect the client to a specific web resorce
     * @param string $route is the route of the web resource to will be redirect the client
    */
    public static function redirectTo(string $route){
        header("Location: /{$route}");
    }

    /**
     * This tuncion returns the currently state of the session Validator (how an helper), see the SessionValidator class and his validateSessionIsActive
    */
    public static function validateSession(){
        return SessionValidator::validateSessionIsActive();
    }

    /**
     * This tuncion is the helper to validate the CSRF Token, return the Forbidden error if the token is not validate, else, destroy it
    */
    protected static function validateCSRFToken(){
        // First get the csrf token
        $csrf_token_obtained = $_POST["csrf-token"] ?? "";
        if(!SessionValidator::comparateCSRFToken($csrf_token_obtained)){
            ExceptionController::returnForbidden();
        }else{
            SessionValidator::destroyCSRFToken();
        }
    }

}