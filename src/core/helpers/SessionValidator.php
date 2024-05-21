<?php
namespace Jdev2\TodoApp\core\helpers;

use Exception;
use Jdev2\TodoApp\core\security\TokenGenerator;
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
    public static function createSession(string $identificator_name, string | int $id_user){
        self::startSession();
        $_SESSION["name_user"] = $identificator_name;
        $_SESSION["id_user"] = $id_user;
        $_SESSION["logguedin"] = true;
    }
    
    /**
     * This function validate if the session is active o no (validate also)
     * @return bool true if the session is active and validate, false if not
    */
    public static function validateSessionIsActive(){
        self::startSession();
        // Remember that empty return false if the var exists and is not cero or "": https://www.php.net/manual/es/function.empty.php
        return !empty($_SESSION["logguedin"]);
    }

    public static function destroySession(){
        self::startSession();
        unset($_SESSION["name_user"]);
        unset($_SESSION["id_user"]);
        unset($_SESSION["logguedin"]);
        session_unset();
        session_destroy();
        $params = session_get_cookie_params();
        setcookie(
            session_name(), "", time() - 220000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    /***
     * This function return the value of the identificator of the user (name)
     */
    public static function returnIdentificatorName(){
        static::startSession();
        if(!static::validateSessionIsActive()){
            return false;
        }
        return $_SESSION["name_user"];
    }

    /***
     * This function return the value of the identificator of the user (id)
     */
    public static function returnIdentificator(){
        static::startSession();
        if(!static::validateSessionIsActive()){
            return false;
        }
        return $_SESSION["id_user"];
    }

    /**
     * This function get an csrf token to save it in the session, is just to use in forms events
    */
    public static function assignCSRFToken() : string{
        static::startSession();
        $_SESSION["csrf_token"] = TokenGenerator::generateCSRFToken();
        return $_SESSION["csrf_token"];
    }

    /**
     * This function DESTROY THE csrf token, must be used when other token has been used
    */
    public static function destroyCSRFToken(){
        static::startSession();
        if(!empty($_SESSION["csrf_token"])){
            unset($_SESSION["csrf_token"]);
        }else{
            throw new Exception("error en destrucción de token", 1);
        }
    }

    /**
     * This function comparate the CSRF Token sended from the client
     * @param string $csrf_token_obtained is the token of the client
     * @return bool: true if the token is validated (form the client and the session is equal), false if not
    */
    public static function comparateCSRFToken(string $csrf_token_obtained){
        static::startSession();
        //dd("Obtenido: {$csrf_token_obtained} y el que tiene en la sesión es: {$_SESSION["csrf_token"]}");
        if(empty($_SESSION["csrf_token"])){
            return false;
        }else{
            return $_SESSION["csrf_token"] === $csrf_token_obtained;
        }
    }

}