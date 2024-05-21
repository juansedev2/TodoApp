<?php
namespace Jdev2\TodoApp\app\policies;

use Exception;
use Jdev2\TodoApp\app\models\Task;
use Jdev2\TodoApp\app\controllers\ExceptionController;
/**
 * This class is the policy validator of the CRUD operations about the tasks resources
*/
class TaskOperationsPolicy{
    
    /**
     * This funciton validates the property of the task resource acording his identification and also of the user
     * @param string|int $id_task is the id of the task resource
     * @param string|int $id_user is the id of the currently user in the session (should be)
    */
    public static function validateTaskPropertyOfUser(string | int $id_task, string | int $id_user){
        // First validate if the data is not empty
        if(empty($id_task) || empty($id_user)){
            return ExceptionController::returnNotFoundView();
        }

        $task = new Task();
        $result = $task->getTaskProperty( $id_task );
            
        if(empty($result)){
            return ExceptionController::returnNotFoundView();
        }
        if(!($result["id_user"] == $id_user)){ // In this case, the id task not belong to the id_user, then that currently user CANNOT see that resource
            return ExceptionController::returnNotFoundView();
        }
        

    }
}