<?php
namespace Jdev2\TodoApp\app\controllers;

use Jdev2\TodoApp\app\models\User;
use Jdev2\TodoApp\core\utils\AppLogger;
use Jdev2\TodoApp\core\helpers\InputValidator;
use Jdev2\TodoApp\core\helpers\SessionValidator;
use Jdev2\TodoApp\app\controllers\BaseController;
use Jdev2\TodoApp\app\controllers\UserController;

class LoginController extends BaseController{

    public function tryLogin(){

        // First, validate if the user already logged before to skip the query
        if(SessionValidator::validateSesstionIsActive()){
            $csrf_token = SessionValidator::assignCSRFToken();
            return static::redirectTo("welcome");
        }
        
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";

        AppLogger::addClientConnectionLog();
        AppLogger::addTryLoginLog();

        if(!$this->validateInputs($email, $password)){
            return $this->showLoginError("Error, sesión no iniciada");
        }

        $email = InputValidator::cleanWhiteSpaces($email);
        $password = InputValidator::cleanWhiteSpaces($password);
        $email = InputValidator::escapeCharacters($email);
        $password = InputValidator::escapeCharacters($password);

        if(!InputValidator::validateIfIsEmail($email)){
            return $this->showLoginError("Error formato de correo electrónico inválido");
        }

        if(!InputValidator::validateMaxLenght($password, 255)){
            return $this->showLoginError("Error, ¿Contraseña de más de 255 caracteres?");
        }

        $user = new User();
        $result = $user->queryUserByEmailAndPassword($email, $password);

        if($result){
            AppLogger::addSucLoginLog($user->email);
            SessionValidator::createSession($user->name . " " .$user->last_name, $user->id_user);
            $user_controller = new UserController();
            $user_controller->returnWelcomeView($user);
        }else{
            AppLogger::addClientActionsLog("Client wit the email input: {$email} try to login, but it failed - ");
            $this->showLoginError("Error, usuario y/o contraseña incorrecto/s");
        }
    }

    public function showLoginError($error_message){
        AppLogger::addClientConnectionLog();
        AppLogger::addClientActionsLog("Client redirect to show login error view");
        return static::returnView("LoginFormError", ["error_message" => $error_message]);
    }

    public function showMainUserView($user_name){
        return static::returnView("LoginMode", ["user_name" => $user_name]);
    }

    public function showWelcome(array $alert_message = []){
        AppLogger::addClientConnectionLog();
        if(!SessionValidator::validateSesstionIsActive()){
            AppLogger::addClientActionsLog("Client redirect to show login error view, but with error because his session is not active - ");
            return $this->showLoginError("Error, sesión no iniciada");
        }
        $user_controller = new UserController();
        AppLogger::addClientActionsLog("Client redirect to welcome view, his session is still active - ");
        $user_controller->returnWelcomeView(id_user: SessionValidator::returnIdentificator(), alert_message: $alert_message);
    }

    private function validateInputs(string $email, string $password){
        return InputValidator::validateAllEmptyStrings([$email, $password]);
    }

    public function closeSession(){
        AppLogger::addClientConnectionLog();
        AppLogger::addClientActionsLog("Client closed session - ");
        SessionValidator::destroySession();
        static::redirectTo("iniciar-sesion");
    }

}