<?php
namespace Jdev2\TodoApp\app\models;

use Exception;
use Jdev2\TodoApp\core\Injector;

// This model is the base of all of the models in the app, this have the common propreties of a model

class Model{

    /**
     * @property string $table_name
     * The name of the model equivalent to the name of the table
    */
    protected static string $table_name = "";
    /**
     * @property string $pk_name
     * The name of the primary key of the model
    */
    protected static string $pk_name = "";
    /**
     * @property array $properties
     * The properties of the model (fields and values of the register according the model (table))
    */
    protected array $properties = [];

    public function __construct(Array $properties = []){
        $this->properties = $properties;
    }

    // General get and set methods FOR USE THE PROPERTIES OF EACH MODEL
    public function __get(string $property){
        if(array_key_exists($property, $this->properties)){
            return $this->properties[$property];
        }
    }

    public function __set(string $property, $value){
        if(array_key_exists($property, $this->properties)){
            $this->properties[$property] = $value;
        }
    }
    
    /***
     * This function update the properties of the instancie, if the property for example is compound how an array, then
     * that value should not be added how others keys in the array properties, instead is better create a new key to save that value, so 
     * it's necessary to give a new key name, but if is not necessary to update the properties to a new property compund, then the function/method
     * updated the properties with an inside array_merge, in that case just send the array of properties to be updated.
     * 
     * @param array $value it's the array of the propertis to will be updated in the instancie
     * @param string $newKey it's the name of the new key to add a compound property
    */
    public function updateProperties(array $value, string $newKey = ""){
        if(empty($newKey)){
            $this->properties = array_merge($this->properties, $value);
        }else{
            $this->properties[$newKey] = $value;
        }
    }

    /**
     * Each model should have return an instance to can continue the model for other actions
    */
    public static function create(Array $properties): static{
        $model = new Static($properties); // This calls the constructor of the model :0
        $model->save();
        return $model;
    }

    // Function to validate the name of the table if not be emtpy
    public static function validateTableName(){
        // ! Validate that the name of the table should not been empty
        if(empty(static::$table_name)){
            throw new Exception("ERROR, NOMBRE DE LA TABLA NO DEFINIDA PARA EL MODELO: " . strtoupper(get_class(new Static)) . "\n", 1);
        }
    }

    
    // Function to the model can create the register
    public function save(){
        static::validateTableName();
        Injector::get("querybuilder")->create(static::$table_name, $this->properties);
    }

    // Function to get all the registers of the table
    public static function getAll(){
        static::validateTableName();
        $records = Injector::get("querybuilder")->selectAll(static::$table_name);
        // To each register, we need to create one model that represent the model and his instancie
        if(is_array($records)){
            $records = array_map(fn($record) => new Static($record), $records);
            return $records;
        }else{
            return false;
        }
    }

    /**
     * Function to get one record/entity
    */
    public static function getOne(string | int $id){
        static::validateTableName();
        $model = new Static();
        $model->searchOne($id);
        return $model;
    }

    public function searchOne(string | int $id){
        $record = Injector::get("querybuilder")->selectOne(static::$table_name, static::$pk_name, $id);
        if(is_array($record)){
            // Insted return the record, we can update the instance of the model
            $this->properties = $record;
        }
    }

    /**
     * Function to update the model
    */
    public static function update(Array $properties, $id){
        static::validateTableName();
        $result = Injector::get("querybuilder")->updateOne(static::$table_name, $id, static::$pk_name, $properties);
        return $result;
    }
    /**
     * Function to delete the model - register
    */
    public static function delete(string | int $id){
        static::validateTableName();
        $result = Injector::get("querybuilder")->delete(static::$table_name, $id, static::$pk_name);
        return $result;
    }

}