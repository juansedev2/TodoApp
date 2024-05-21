<?php
namespace Jdev2\TodoApp\app\controllers;

use Exception;
use Jdev2\TodoApp\app\models\User;
use Jdev2\TodoApp\core\utils\AppLogger;
use Jdev2\TodoApp\core\security\Encryptor;
use Jdev2\TodoApp\core\helpers\InputValidator;
use Jdev2\TodoApp\core\helpers\SessionValidator;
use Jdev2\TodoApp\app\controllers\BaseController;
use Jdev2\TodoApp\app\controllers\ExceptionController;

class UserController extends BaseController{

    /**
     * This function gets the welcome view for the user, also show the tasks if the user have, but also maks the CSRF and session validation validation
     * @param User $user is the user model to get the task resources and his data, is optional according if the $id_user is sendend, if is not sendin, at least $id_user will be sending, in other case, show the error view
     * @param string|int $id_user is the id of the user to get the resources of the main view (welcome view or UserMain view)
     * @param array $alert_messsage is the array of the alert messages of the operations by the logged user in the app, it's optional if is not necessary share some message
    */
    public function returnWelcomeView(User $user = null, string | int $id_user = null, array $alert_message = []){

        // Create the csrf token
        $csrf_token = SessionValidator::assignCSRFToken();

        if(is_null($user) && is_null($id_user)){
            // return throw new Exception("El parametro user o id_user NO PUEDEN SER NULOS, DEBE ENVIARSE AL MENOS 1", 1);
            return ExceptionController::returnInternalServerErrorView();
        }else if($user){
            $user->getTasksForUser($user->id_user);
        }else{
            $user = new User();
            $user->getTasksForUser($id_user);
        }
        AppLogger::addClientConnectionLog();
        $action = "{$user->email} has to acces to the welcome view to show that main view";
        AppLogger::addClientActionsLog($action);
        static::returnView("UserMain", array_merge(["user" => $user, "csrf_token" => $csrf_token], $alert_message));
    }
    /**
     *This funciton creates a new user, validate the data of the Register view and create the resource (user) only if all the data has correct format, else, return a error message on the view
    */
    public function createUser(){

        AppLogger::addClientConnectionLog();
        
        $name = $_POST["name"] ?? "";
        $last_name = $_POST["last-name"] ?? "";
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";
        $password2 = $_POST["password2"] ?? "";

        $name = InputValidator::escapeCharacters($name);
        $last_name = InputValidator::escapeCharacters($last_name);
        $email = InputValidator::escapeCharacters($email);
        $password = InputValidator::escapeCharacters($password);
        $password2 = InputValidator::escapeCharacters($password2);

        if(InputValidator::validateAllEmptyStrings([$name, $last_name, $email, $password, $password2])){

            if(!InputValidator::validateMaxLenght($name, 20)){
                return static::returnView("Register", ["alert" => "El nombre del usuario no puede superar los 20 caracteres", "color_alert" => "alert-warning"]);
            }

            if(!InputValidator::validateMaxLenght($last_name, 20)){
                return static::returnView("Register", ["alert" => "El apellido del usuario no puede superar los 20 caracteres", "color_alert" => "alert-warning"]);
            }

            if(!InputValidator::validateIfIsEmail($email)){
                return static::returnView("Register", ["alert" => "Formato de correo no válido", "color_alert" => "alert-warning"]);
            }

            // Validate if the email exists!
            $result = (new User)->queryUserByEmail($email);

            if((new User)->queryUserByEmail($email)){
                return static::returnView("Register", ["alert" => "¡Error, ese usuario ya existe!", "color_alert" => "alert-danger"]);
            }

            if(!InputValidator::validateIfPasswordIsSecure($password)){
                return static::returnView("Register", ["alert" => "La contraseña debe ser de mínimo 8 caracteres, al menos una letra en maýuscula, al menos un número y un caracter especial, al menos", "color_alert" => "alert-warning"]);
            }

            if(!InputValidator::validateIfPasswordIsSecure($password2)){
                return static::returnView("Register", ["alert" => "La contraseña debe ser de mínimo 8 caracteres, al menos una letra en maýuscula, al menos un número y un caracter especial, al menos", "color_alert" => "alert-warning"]);
            }

            if($password !== $password2){
                return static::returnView("Register", ["alert" => "Las contraseñas no coinciden", "color_alert" => "alert-warning"]);
            }

            $password = Encryptor::encryptPassword($password);

            $result = User::create(["name" => $name, "last_name" => $last_name, "email" => $email, "password" => $password]);

            if($result->state_creation_operation){
                $action = "A new user has been created by the email: {$email} - ";
                AppLogger::addClientActionsLog($action);
                return static::returnView("Register", ["alert" => "Usuario registado exitosamente, ya puedes iniciar sesión con tus datos", "color_alert" => "alert-success"]);
            }else{
                $action = "User {$email} CANNOT create a new user resource";
                AppLogger::addClientActionsLog($action);
                return static::returnView("Register", ["alert" => "Hubo un error al crear el usurio, por favor intente después, mil disculpas", "color_alert" => "alert-danger"]);
            }
        }else{
            return static::returnView("Register", ["alert" => "Campos incompletos, por favor llenar toda la información", "color_alert" => "alert-warning"]);
        }

    }

}