<?php
namespace Jdev2\TodoApp\app\models;

use Jdev2\TodoApp\app\models\Model;
use Jdev2\TodoApp\core\Injector;

class Task extends Model{
    /**
     * @property string $table_name
     * The name of the model equivalent to the name of the table
    */
    protected static string $table_name = "tasks";
    /**
     * @property string $pk_name
     * The name of the primary key of the model
    */
    protected static string $pk_name = "id_task";
    /**
     * @property array $properties
     * The properties of the model (fields and values of the register according the model (table))
    */
    protected array $properties = [];

    public function __construct(Array $properties = []){
        parent::__construct($properties);
    }

    /**
     * This funciton calls the store procedure to get an specific task in the table
    */
    public function getInfoTaskById(string | int $id_task): array | bool{
        $query = "CALL getInfoTaskById(?)";
        $result = Injector::get("querybuilder")->ownQuery($query, [$id_task], true);
        if(empty($result)){
            return false;
        }else{
            $this->updateProperties($result[0]);
            return true;
        }
    }

    public function updateTask(string | int $id_task, string $title_task, string $task_description): array | bool{
        $query = "CALL updateTask(?, ?, ?)";
        $result = Injector::get("querybuilder")->ownQuery($query, [$id_task, $title_task, $task_description]);
        return $result;
    }

    public function insertTask(string | int $id_user, string $title_task, string $task_description): array | bool{
        $query = "CALL insertTask(?, ?, ?)";
        $result = Injector::get("querybuilder")->ownQuery($query, [$id_user, $title_task, $task_description]);
        return $result;
    }

    public function deleteTask(string | int $id_task){
        $query = "CALL deleteTask(?)";
        $result = Injector::get("querybuilder")->ownQuery($query, [$id_task]);
        return $result;
    }

    /**
     * This function call the store procedure getTaskProperty to get the data about the property of the task, his id and the user id.
     * It's important to know that this function only returns the first result, because only task resource belongs to one user, then return only one record
    */
    public function getTaskProperty(string | int $id_task){
        $query = "CALL getTaskProperty(?)";
        $result = Injector::get("querybuilder")->ownQuery($query, [$id_task], true);
        return $result[0];
    }

}