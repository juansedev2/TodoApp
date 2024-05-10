<?php
namespace Jdev2\TodoApp\core\helpers;

use Jdev2\TodoApp\app\controllers\LoginController;
class SessionValidator{

    public static function startSession(){ // to create or reactivate a session, always is necessary start it
        if(empty(session_id())){
            session_start(
                [
                    "cookie_lifetime" => 0, 
                    "cookie_httponly" => true
                ]
            );
        }
    }

    /**
     * @param string $identificator_name is the name of the main indentificator of the user (name, email) and that can be showed in public
    */
    public static function createSession(string $identificator_name){
        self::startSession();
        $_SESSION["name_user"] = $identificator_name;
        $_SESSION["logguedin"] = true;
    }
    
    /**
     * This function validate if the session is active o no (validate also)
     * @return bool true if the session is active and validate, false if not
    */
    public static function validateSesstionIsActive(){
        self::startSession();
        // Remember that empty return false if the var exists and is not cero or "": https://www.php.net/manual/es/function.empty.php
        return !empty($_SESSION["logguedin"]);
    }

    public static function destroySession(){
        self::startSession();
        unset($_SESSION["name_user"]);
        unset($_SESSION["logguedin"]);
        session_unset();
        session_destroy();
        $params = session_get_cookie_params();
        setcookie(
            session_name(), null, time() - 220000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    /***
     * This function return the value of the identificator of the user
     */
    public static function returnIdentificatorName(){
        static::startSession();
        if(!static::validateSesstionIsActive()){
            
        }
        return $_SESSION["name_user"];
    }

}