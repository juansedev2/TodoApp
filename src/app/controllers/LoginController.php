<?php
namespace Jdev2\TodoApp\app\controllers;

use Jdev2\TodoApp\app\models\User;
use Jdev2\TodoApp\core\utils\AppLogger;
use Jdev2\TodoApp\core\helpers\InputValidator;
use Jdev2\TodoApp\core\helpers\SessionValidator;
use Jdev2\TodoApp\app\controllers\BaseController;
use Jdev2\TodoApp\app\controllers\UserController;

/**
 * This class is the controller of the login actions of the user
*/
class LoginController extends BaseController{

    /**
     * This function gets the data when the user try the login action in the app, if it's succsesful, then return the welcome view, else, return the login form with the error message
    */
    public function tryLogin(){

        // First, validate if the user already logged before to skip the query
        if(SessionValidator::validateSessionIsActive()){
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
    /**
     * This function returns the form view with the error message
     * @param string $error_message is the description of the error to show in the login error view
    */
    public function showLoginError(string $error_message){
        AppLogger::addClientConnectionLog();
        AppLogger::addClientActionsLog("Client redirect to show login error view");
        return static::returnView("LoginFormError", ["error_message" => $error_message]);
    }
    /**
     * This function returns login mode user view
     * @param string $user_name is the name of the user
     * !THIS FUNCTION IS NOT OPERATIONAL, discard this function until further notice
    */
    public function showMainUserView(string $user_name){
        return static::returnView("LoginMode", ["user_name" => $user_name]);
    }
    /**
     * This function returns the main view of the user logged in, the main view with an possible alert message about the CRUD operations
     * @param array $alert_message is the array with the messages to show in the UserMain view (shoul will be an associative array to will be extract it)
    */
    public function showWelcome(array $alert_message = []){
        AppLogger::addClientConnectionLog();
        if(!SessionValidator::validateSessionIsActive()){
            AppLogger::addClientActionsLog("Client redirect to show login error view, but with error because his session is not active - ");
            return $this->showLoginError("Error, sesión no iniciada");
        }
        $user_controller = new UserController();
        AppLogger::addClientActionsLog("Client redirect to welcome view, his session is still active - ");
        $user_controller->returnWelcomeView(id_user: SessionValidator::returnIdentificator(), alert_message: $alert_message);
    }
    /**
     * This function returns the validate inputs operations of the email and password data with the InputValidator class, see this class and his validateAllEmptyStrings method
    */
    private function validateInputs(string $email, string $password){
        return InputValidator::validateAllEmptyStrings([$email, $password]);
    }
    /**
     * This function CLOSE the currently sesison of the user with the SessionValidator class, see the destroySession method, and redirect the client to the login form view
    */
    public function closeSession(){
        AppLogger::addClientConnectionLog();
        AppLogger::addClientActionsLog("Client closed session - ");
        SessionValidator::destroySession();
        static::redirectTo("iniciar-sesion");
    }

}