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



}