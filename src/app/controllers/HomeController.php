<?php
namespace Jdev2\TodoApp\app\controllers;

use Jdev2\TodoApp\app\controllers\BaseController;
use Jdev2\TodoApp\app\models\User;

class HomeController extends BaseController{

    public function __construct() {}

    public function showLanding(){
        return static::returnView("Landing");
    }

    public function showLoginForm(){
        return static::returnView("LoginForm");
    }

    public function showRegister(){
        return static::returnView("Register");
    }

    public function showAbout(){
        return static::returnView("About");
    }

    public function showGuestMode(){
        return static::returnView("GuestMode");
    }
}