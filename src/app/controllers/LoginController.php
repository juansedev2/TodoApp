<?php
namespace Jdev2\TodoApp\app\controllers;

use Jdev2\TodoApp\app\controllers\BaseController;
use Jdev2\TodoApp\app\models\User;
use Jdev2\TodoApp\core\helpers\SessionValidator;
use Jdev2\TodoApp\core\helpers\InputValidator;

class LoginController extends BaseController{

    public function tryLogin(){

        // First, validate if the user already logged before to skip the query
        if(SessionValidator::validateSesstionIsActive()){
            return static::redirectTo("welcome");
        }
        
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";

        if(!$this->validateInputs($email, $password)){
            return $this->showLoginError("Error, sesión no iniciada");
        }

        $user = new User();
        $result = $user->queryUserByEmailAndPassword($email, $password);

        if($result){
            SessionValidator::createSession($user->name . " " .$user->last_name);
            $this->showWelcome();
        }else{
            $this->showLoginError("Error, usuario y/o contraseña incorrecto/s");
        }
    }

    public function showLoginError($error_message){
        return static::returnView("LoginFormError", ["error_message" => $error_message]);
    }

    public function showMainUserView($user_name){
        return static::returnView("LoginMode", ["user_name" => $user_name]);
    }

    public function showWelcome(){
        if(!SessionValidator::validateSesstionIsActive()){
            return $this->showLoginError("Error, sesión no iniciada");
        }
        return static::returnView("UserMain");
    }

    private function validateInputs(string $email, string $password){
        return InputValidator::validateAllEmptyStrings([$email, $password]);
    }

    public function closeSession(){
        SessionValidator::destroySession();
        static::redirectTo("iniciar-sesion");
    }

}