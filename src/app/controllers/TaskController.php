<?php
namespace Jdev2\TodoApp\app\controllers;

use Exception;
use Jdev2\TodoApp\app\models\Task;
use Jdev2\TodoApp\core\helpers\InputValidator;
use Jdev2\TodoApp\core\helpers\SessionValidator;
use Jdev2\TodoApp\app\controllers\BaseController;
use Jdev2\TodoApp\app\controllers\LoginController;
use Jdev2\TodoApp\app\controllers\ExceptionController;


class TaskController extends BaseController{

    public function showUpdateTaskView(){
        if(static::validateSession()){
            $id_task = $_POST["id_task"] ?? "";
            $id_task = InputValidator::escapeCharacters(InputValidator::cleanWhiteSpaces($id_task));

            if(empty($id_task)){
                //return throw new Exception("NINGUN DATO FUE ENVIADO, MOSTRAR ERROR", 1);
                return (new LoginController)->showWelcome(["message" => "Error de solicitud", "color" => "alert-warning"]);
            }else{
                $task = new Task;
                $result = $task->getInfoTaskById($id_task);
                if($result){
                    return static::returnView("UpdateTask", ["task" => $task]);
                }else{
                    //return throw new Exception("404, tarea no encontrada", 1);
                    return ExceptionController::returnNotFoundView();
                }
            }
        }else{
            return (new LoginController)->showLoginError("Error, sesión no iniciada");
        }

    }

    public function updateTask(){
        if(static::validateSession()){
            
            $id_task = $_POST["task-id"] ?? "";
            $title_task = $_POST["task-title"] ?? "";
            $task_description = $_POST["task-description"] ?? "";

            $id_task = InputValidator::escapeCharacters(InputValidator::cleanWhiteSpaces($id_task));
            $title_task = InputValidator::escapeCharacters($title_task);
            $task_description = InputValidator::escapeCharacters($task_description);

            if(!InputValidator::validateMaxLenght($title_task, 30)){
                return (new LoginController)->showWelcome(["message" => "El título no puede superar los 30 caracteres", "color" => "alert-warning"]);
            }
            if(!InputValidator::validateMaxLenght($task_description, 200)){
                return (new LoginController)->showWelcome(["message" => "La descripción de la tarea no puede superar los 200 caracteres", "color" => "alert-warning"]);
            }
            
            if(!InputValidator::validateAllEmptyStrings([$id_task, $title_task, $task_description])){
                // return throw new Exception("DATOS INCOMPLETOS MOSTRAR ERROR", 1);
                return (new LoginController)->showWelcome(["message" => "Error, datos incompletos", "color" => "alert-warning"]);
            }else{
                $result = (new Task)->updateTask($id_task, $title_task, $task_description);
                if($result){
                    return static::redirectTo("welcome");
                }else{
                    //return throw new Exception("500, no se pudo actualizar la tarea, error de servidor", 1);
                    return (new LoginController)->showWelcome(["message" => "Hubo un error al intentar insertar la tarea, por favor intentar después", "color" => "alert-danger"]);
                }
            }
        }else{
            return (new LoginController)->showLoginError("Error, sesión no iniciada");
        }
    }

    public function createTask(){
        if(static::validateSession()){
            
            $id_user = SessionValidator::returnIdentificator();
            $title_task = $_POST["title-task"] ?? "";
            $task_description = $_POST["description-task"] ?? "";

            $id_user = InputValidator::escapeCharacters(InputValidator::cleanWhiteSpaces($id_user));
            $title_task = InputValidator::escapeCharacters($title_task);
            $task_description = InputValidator::escapeCharacters($task_description);

            if(!InputValidator::validateMaxLenght($title_task, 30)){
                return (new LoginController)->showWelcome(["message" => "El título no puede superar los 30 caracteres", "color" => "alert-warning"]);
            }
            if(!InputValidator::validateMaxLenght($task_description, 200)){
                return (new LoginController)->showWelcome(["message" => "La descripción de la tarea no puede superar los 200 caracteres", "color" => "alert-warning"]);
            }
            
            if(!InputValidator::validateAllEmptyStrings([$id_user, $title_task, $task_description])){
                return (new LoginController)->showWelcome(["message" => "Error, datos incompletos", "color" => "alert-warning"]);
            }else{

                $result = (new Task)->insertTask($id_user, $title_task, $task_description);

                if($result){
                    return static::redirectTo("welcome");
                }else{
                    //return throw new Exception("500, no se pudo crear la tarea, error de servidor", 1);
                    return (new LoginController)->showWelcome(["message" => "Hubo un error al intentar insertar la tarea, por favor intentar después", "color" => "alert-danger"]);
                }
            }
        }else{
            return (new LoginController)->showLoginError("Error, sesión no iniciada");
        }
    }

    public function deleteTask(){

        if(static::validateSession()){
            
            $id_task_input_button = $_POST["id_task_input_button"] ?? "";
            $id_task_input_button = InputValidator::escapeCharacters(InputValidator::cleanWhiteSpaces($id_task_input_button));
            
            if(empty($id_task_input_button)){
                return (new LoginController)->showWelcome(["message" => "Error de solicitud", "color" => "alert-danger"]);
            }else{
                $result = (new Task)->deleteTask($id_task_input_button);
                if($result){
                    return static::redirectTo("welcome");
                }else{
                    //return throw new Exception("500, no se pudo eliminar la tarea, error de servidor", 1);
                    return ExceptionController::returnInternalServerErrorView();
                }
            }
        }else{
            return (new LoginController)->showLoginError("Error, sesión no iniciada");
        }
    }



}