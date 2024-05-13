<?php
namespace Jdev2\TodoApp\app\controllers;

use Exception;
use Jdev2\TodoApp\app\models\User;
use Jdev2\TodoApp\app\controllers\BaseController;
use Jdev2\TodoApp\core\helpers\InputValidator;
use Jdev2\TodoApp\core\security\Encryptor;

class UserController extends BaseController{

    /**
     * This function gets the welcome view for the user, also show the tasks if the user have
    */
    public function returnWelcomeView(User $user = null, string | int $id_user = null){
        if(is_null($user) && is_null($id_user)){
            return throw new Exception("El parametro user o id_user NO PUEDEN SER NULOS, DEBE ENVIARSE AL MENOS 1", 1);
        }else if($user){
            $user->getTasksForUser($user->id_user);
        }else{
            $user = new User();
            $user->getTasksForUser($id_user);
        }
        //dd($user->tasks[0]);
        static::returnView("UserMain", ["user" => $user]);
    }

    public function createUser(){
        // TODO: TERMINAR LA VALIDACIÓN DE LOS CAMPOS QUE LLEGAN
        
        $name = $_POST["name"] ?? "";
        $last_name = $_POST["last-name"] ?? "";
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";
        $password2 = $_POST["password2"] ?? "";

        if(InputValidator::validateAllEmptyStrings([$name, $last_name, $email, $password, $password2])){
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