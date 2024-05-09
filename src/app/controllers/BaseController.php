<?php
namespace Jdev2\TodoApp\app\controllers;

use Jdev2\TodoApp\core\Injector;

class BaseController{

    public static function returnView(string $view, Array $params = []){
        extract($params);
        require Injector::get("app-route") . "/public/views/" . $view . ".view.php";
    }
}