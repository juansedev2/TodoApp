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

}