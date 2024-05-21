<?php
namespace Jdev2\TodoApp\app\controllers;

use Exception;
use Jdev2\TodoApp\core\Injector;
use Jdev2\TodoApp\app\models\Task;
use Jdev2\TodoApp\core\utils\AppLogger;
use Jdev2\TodoApp\core\helpers\InputValidator;
use Jdev2\TodoApp\core\helpers\SessionValidator;
use Jdev2\TodoApp\app\controllers\BaseController;
use Jdev2\TodoApp\app\controllers\LoginController;
use Jdev2\TodoApp\app\controllers\ExceptionController;
use Jdev2\TodoApp\app\policies\TaskOperationsPolicy;

/**
 * This class is the controller to the task model and his operations about CRUD example and others
*/
class TaskController extends BaseController{

    /**
     * This function show the update task view, get the data and return the view, if not, then returns the error according if the resource if not exists or if the session is not active
    */
    public function showUpdateTaskView(){

        if(static::validateSession()){

            AppLogger::addClientConnectionLog();
            // Always first validate Token
            static::validateCSRFToken();

            $id_task = $_POST["id_task"] ?? "";
            $id_task = InputValidator::escapeCharacters(InputValidator::cleanWhiteSpaces($id_task));

            if(empty($id_task)){
                AppLogger::addClientActionsLog("Client get an empty task id resource");
                //return throw new Exception("NINGUN DATO FUE ENVIADO, MOSTRAR ERROR", 1);
                return (new LoginController)->showWelcome(["message" => "Error de solicitud", "color" => "alert-warning"]);
            }else{

                // First, validate the property to show the resorce
                TaskOperationsPolicy::validateTaskPropertyOfUser($id_task, SessionValidator::returnIdentificator());
                $task = new Task;
                $result = $task->getInfoTaskById($id_task);
                if($result){
                    $csrf_token = SessionValidator::assignCSRFToken();
                    AppLogger::addClientActionsLog("Client get the update task view");
                    return static::returnView("UpdateTask", ["task" => $task, "csrf_token" => $csrf_token]);
                }else{
                    AppLogger::addClientActionsLog("Client cannot get the taks update view resource because the task resource cannot be getting");
                    //return throw new Exception("404, tarea no encontrada", 1);
                    return ExceptionController::returnNotFoundView();
                }
            }
        }else{
            return (new LoginController)->showLoginError("Error, sesión no iniciada");
        }

    }
    /**
     * This function updates an specific resource sending by the data that the client sending, validates if the resource exists, validations of the data, CSRF, and more
    */
    public function updateTask(){

        AppLogger::addClientConnectionLog();

        if(static::validateSession()){

            // Always first validate Token
            static::validateCSRFToken();
            
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
                // return throw new Exception("DATOS INCOMPLETOS MOSTRAR ERROR", 1);}
                AppLogger::addClientActionsLog("Client doesn't send all necessary data to update the task resource");
                return (new LoginController)->showWelcome(["message" => "Error, datos incompletos", "color" => "alert-warning"]);
            }else{

                // First, validate the property to show the resorce
                TaskOperationsPolicy::validateTaskPropertyOfUser($id_task, SessionValidator::returnIdentificator());
                $result = (new Task)->updateTask($id_task, $title_task, $task_description);
                if($result){
                    AppLogger::addClientActionsLog("Client update the task resource {$id_task}");
                    return static::redirectTo("welcome");
                }else{
                    //return throw new Exception("500, no se pudo actualizar la tarea, error de servidor", 1);
                    AppLogger::addClientActionsLog("Client cannot update the task resource {$id_task}");
                    return (new LoginController)->showWelcome(["message" => "Hubo un error al intentar actualizar la tarea, por favor intentar después", "color" => "alert-danger"]);
                }
            }
        }else{
            return (new LoginController)->showLoginError("Error, sesión no iniciada");
        }
    }
    /**
     * This function create a task resource sending by the data that the client sending, validates if the resource exists, validations of the data, CSRF, and more
    */
    public function createTask(){

        AppLogger::addClientConnectionLog();

        if(static::validateSession()){

            // Always first validate Token
            static::validateCSRFToken();
            
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
                    $action = "User create a task resource " . SessionValidator::returnIdentificatorName();
                    AppLogger::addClientActionsLog($action);
                    return static::redirectTo("welcome");
                }else{
                    //return throw new Exception("500, no se pudo crear la tarea, error de servidor", 1);
                    $action = "User CANNOT create a task resource " . SessionValidator::returnIdentificatorName() . " - see the log errors";
                    AppLogger::addClientActionsLog($action);
                    return (new LoginController)->showWelcome(["message" => "Hubo un error al intentar insertar la tarea, por favor intentar después", "color" => "alert-danger"]);
                }
            }
        }else{
            return (new LoginController)->showLoginError("Error, sesión no iniciada");
        }
    }

    /**
     * This function delete an specific task resource sending by the data that the client sending, validates if the resource exists, validations of the data, CSRF, and more
    */
    public function deleteTask(){

        AppLogger::addClientConnectionLog();

        if(static::validateSession()){

            // Always first validate Token
            static::validateCSRFToken();
            
            $id_task_input_button = $_POST["id_task_input_button"] ?? "";
            $id_task_input_button = InputValidator::escapeCharacters(InputValidator::cleanWhiteSpaces($id_task_input_button));
            
            if(empty($id_task_input_button)){
                    $action = "Client doesn't send the id task resource";
                    AppLogger::addClientActionsLog($action);
                return (new LoginController)->showWelcome(["message" => "Error de solicitud", "color" => "alert-danger"]);
            }else{
                // First, validate the property to show the resorce
                TaskOperationsPolicy::validateTaskPropertyOfUser($id_task_input_button, SessionValidator::returnIdentificator());
                $result = (new Task)->deleteTask($id_task_input_button);
                if($result){
                    $action = "Client DELETE the id {$id_task_input_button} task resource";
                    AppLogger::addClientActionsLog($action);
                    return static::redirectTo("welcome");
                }else{
                    //return throw new Exception("500, no se pudo eliminar la tarea, error de servidor", 1);
                    $action = "Client cannot DELETE the id {$id_task_input_button} task resource";
                    AppLogger::addClientActionsLog($action);
                    return ExceptionController::returnInternalServerErrorView();
                }
            }
        }else{
            return (new LoginController)->showLoginError("Error, sesión no iniciada");
        }
    }



}