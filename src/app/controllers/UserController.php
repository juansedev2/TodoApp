<?php
namespace Jdev2\TodoApp\app\controllers;

use Exception;
use Jdev2\TodoApp\app\models\User;
use Jdev2\TodoApp\app\controllers\BaseController;

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

}