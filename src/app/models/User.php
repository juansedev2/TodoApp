<?php
namespace Jdev2\TodoApp\app\models;

use Jdev2\TodoApp\core\Injector;
use Jdev2\TodoApp\app\models\Model;
use Jdev2\TodoApp\core\security\Encryptor;

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

    /**
     * @param string $email_user is the email of the user to query in the db
     * @return bool | array false if the query doesn't find any user to the email, array with it's data in otherwise
    */
    public function queryUserByEmailAndPassword(string $email_user, string $password) : bool | Array{
        
        $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $result = Injector::get("querybuilder")->ownQuery($query, [$email_user]);

        if(empty($result)){
            return false;
        }else{
            $this->properties = $result[0];
            if($this->validatePassword($password, $this->password)){
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * This function validates the password hashed to know if is really the password's user
    */
    private function validatePassword(string $literal_password, string $encrypted_password){
        return Encryptor::comparePassword($literal_password, $encrypted_password);
    }
}