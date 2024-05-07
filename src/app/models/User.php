<?php
namespace Jdev2\TodoApp\app\models;

use Jdev2\TodoApp\app\models\Model;

// This model is the base of all of the models in the app, this have the common propreties of a model

class User extends Model{

    /**
     * @property string $table_name
     * The name of the model equivalent to the name of the table
    */
    protected static string $table_name = "user";
    /**
     * @property string $pk_name
     * The name of the primary key of the model
    */
    protected static string $pk_name = "id_user";
    /**
     * @property array $properties
     * The properties of the model (fields and values of the register according the model (table))
    */
    protected array $properties = [];

    public function __construct(Array $properties = []){
        parent::__construct($properties);
    }
}