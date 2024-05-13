<?php
namespace Jdev2\TodoApp\app\controllers;

use Exception;
use Jdev2\TodoApp\core\helpers\SessionValidator;
use Jdev2\TodoApp\app\controllers\BaseController;
use Jdev2\TodoApp\app\controllers\LoginController;
use Jdev2\TodoApp\app\models\Task;


class TaskController extends BaseController{

    public function showUpdateTaskView(){
        if(static::validateSession()){
            $id_task = $_POST["id_task"] ?? "";
            if(empty($id_task)){
                return throw new Exception("NINGUN DATO FUE ENVIADO, MOSTRAR ERROR", 1);
            }else{
                $task = new Task;
                $result = $task->getInfoTaskById($id_task);
                if($result){
                    return static::returnView("UpdateTask", ["task" => $task]);
                }else{
                    return throw new Exception("404, tarea no encontrada", 1);
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
            
            if(empty($id_task) || empty($title_task) || empty($task_description)){
                return throw new Exception("DATOS INCOMPLETOS MOSTRAR ERROR", 1);
            }else{
                $result = (new Task)->updateTask($id_task, $title_task, $task_description);
                if($result){
                    return static::redirectTo("welcome");
                }else{
                    return throw new Exception("500, no se pudo actualizar la tarea, error de servidor", 1);
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
            
            if(empty($id_user) || empty($title_task) || empty($task_description)){
                return throw new Exception("DATOS INCOMPLETOS MOSTRAR ERROR", 1);
            }else{
                $result = (new Task)->insertTask($id_user, $title_task, $task_description);
                if($result){
                    return static::redirectTo("welcome");
                }else{
                    return throw new Exception("500, no se pudo crear la tarea, error de servidor", 1);
                }
            }
        }else{
            return (new LoginController)->showLoginError("Error, sesión no iniciada");
        }
    }

    public function deleteTask(){

        if(static::validateSession()){
            
            $id_task_input_button = $_POST["id_task_input_button"] ?? "";
            
            if(empty($id_task_input_button)){
                return throw new Exception("DATOS INCOMPLETOS MOSTRAR ERROR", 1);
            }else{
                $result = (new Task)->deleteTask($id_task_input_button);
                if($result){
                    return static::redirectTo("welcome");
                }else{
                    return throw new Exception("500, no se pudo eliminar la tarea, error de servidor", 1);
                }
            }
        }else{
            return (new LoginController)->showLoginError("Error, sesión no iniciada");
        }
    }



}