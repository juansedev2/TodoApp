<?php
namespace Jdev2\TodoApp\core\router;
class Handler{

    /**
     * This class only do cleaning of the url request
    */
    public static function handleRequest(){
        return trim($_SERVER["REQUEST_URI"], "/");
    }
}