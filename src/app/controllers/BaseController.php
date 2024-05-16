<?php
namespace Jdev2\TodoApp\app\controllers;

use Jdev2\TodoApp\core\Injector;
use Jdev2\TodoApp\core\helpers\SessionValidator;

class BaseController{

    public static function returnView(string $view, Array $params = []){
        extract($params);
        require Injector::get("app-route") . "/public/views/" . $view . ".view.php";
    }

    public static function redirectTo(string $route){
        header("Location: /{$route}");
    }

    /**
     * Some of the controllers must need validate implement the sessionValidator
    */
    public static function validateSession(){
        return SessionValidator::validateSesstionIsActive();
    }

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