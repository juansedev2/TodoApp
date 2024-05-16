<?php
namespace Jdev2\TodoApp\app\controllers;

use Jdev2\TodoApp\app\controllers\BaseController;
/**
 * This class is the controller of the errors in the app, for example the classics http 500, 404, etc 
*/
class ExceptionController extends BaseController{

    /**
     * This function return the 404 view not found view
    */
    public static function returnNotFoundView(){
        header("HTTP/1.1 404 Not Found", true, 404);
        static::returnView("NotFound");
        exit();
    }

    /**
     * This function return the 500 internal server error view
    */
    public static function returnInternalServerErrorView(){
        header("HTTP/1.1 500 Internal Server Error", true, 500);
        static::returnView("InternalServerError");
        exit();
    }

    /**
     * This function return the 500 internal server error view
    */
    public static function returnForbidden(){
        header("HTTP/1.1 403 Forbidden", true, 403);
        static::returnView("Forbidden");
        exit();
    }

}