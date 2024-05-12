<?php
namespace Jdev2\TodoApp\app\controllers;

use Jdev2\TodoApp\app\controllers\BaseController;
use Jdev2\TodoApp\app\models\User;
use Jdev2\TodoApp\core\helpers\SessionValidator;
use Jdev2\TodoApp\core\helpers\InputValidator;
use Jdev2\TodoApp\app\controllers\UserController;

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
            SessionValidator::createSession($user->name . " " .$user->last_name, $user->id_user);
            $user_controller = new UserController();
            $user_controller->returnWelcomeView($user);
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
        $user_controller = new UserController();
        $user_controller->returnWelcomeView(id_user: SessionValidator::returnIdentificator());
    }

    private function validateInputs(string $email, string $password){
        return InputValidator::validateAllEmptyStrings([$email, $password]);
    }

    public function closeSession(){
        SessionValidator::destroySession();
        static::redirectTo("iniciar-sesion");
    }

}