<?php
namespace Jdev2\TodoApp\app\controllers;

use Exception;
use Jdev2\TodoApp\app\models\User;
use Jdev2\TodoApp\app\controllers\BaseController;
use Jdev2\TodoApp\core\helpers\InputValidator;
use Jdev2\TodoApp\core\security\Encryptor;
use Jdev2\TodoApp\app\controllers\ExceptionController;

class UserController extends BaseController{

    /**
     * This function gets the welcome view for the user, also show the tasks if the user have
    */
    public function returnWelcomeView(User $user = null, string | int $id_user = null, array $alert_message = []){
        if(is_null($user) && is_null($id_user)){
            // return throw new Exception("El parametro user o id_user NO PUEDEN SER NULOS, DEBE ENVIARSE AL MENOS 1", 1);
            return ExceptionController::returnInternalServerErrorView();
        }else if($user){
            $user->getTasksForUser($user->id_user);
        }else{
            $user = new User();
            $user->getTasksForUser($id_user);
        }
        static::returnView("UserMain", array_merge(["user" => $user], $alert_message));
    }

    public function createUser(){
        
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
                return static::returnView("Register", ["alert" => "Usuario registado exitosamente, ya puedes iniciar sesión con tus datos", "color_alert" => "alert-success"]);
            }else{
                return static::returnView("Register", ["alert" => "Hubo un error al crear el usurio, por favor intente después, mil disculpas", "color_alert" => "alert-danger"]);
            }
        }else{
            return static::returnView("Register", ["alert" => "Campos incompletos, por favor llenar toda la información", "color_alert" => "alert-warning"]);
        }

    }

}