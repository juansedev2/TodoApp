<?php
namespace Jdev2\TodoApp\app\controllers;

use Jdev2\TodoApp\app\models\User;
use Jdev2\TodoApp\core\helpers\SessionValidator;
use Jdev2\TodoApp\app\controllers\BaseController;
/**
 * This class is the home controller to the main views in the app
*/
class HomeController extends BaseController{

    public function __construct() {}
    /**
     * This function returns the show landing view
    */
    public function showLanding(){
        return static::returnView("Landing");
    }
    /**
     * This function returns the LoginForm view, but if the session of the user is active, then return the welcome view (this is for not ask again the credentials of the user if the user is logged in)
    */
    public function showLoginForm(){
        if(SessionValidator::validateSessionIsActive()){
            return static::redirectTo("welcome");
        }
        return static::returnView("LoginForm");
    }
    /**
     * This function returns the register view
    */
    public function showRegister(){
        return static::returnView("Register");
    }
    /**
     * This function returns the about view
    */
    public function showAbout(){
        return static::returnView("About");
    }
    /**
     * This function returns the guestmodeapp view
    */
    public function showGuestMode(){
        return static::returnView("GuestMode");
    }
}