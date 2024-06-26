<?php
namespace Jdev2\TodoApp\core\database;

use PDO;
use Exception;
use PDOException;
use Jdev2\TodoApp\core\Injector;
use Jdev2\TodoApp\core\utils\AppLogger;

/**
 * This class is the QueryBuilder of the app that makes the queries with the DB
*/
class QueryBuilder{
    /***
     * The constructor gets a pdo connection
     * @param $pdo is the pdo connection
    */
    public function __construct(private $pdo){}

    /**
     * This function close manually the pdo connection of the currently QueyBuilder instance
    */
    public function __destruct(){
        $this->pdo = null;
    }

    // CRUD OPERATIONS
    
    /**
     * This function gets all (SELECT ALL) of the records and all his data according of a table name, if any record exists, then return it in a associate array, else return null
     * @param string $table_name is the name of the table in the database
     * @return array|null return an array associative that contain each record, else, return null in case of failed or if any record exists
    */
    public function selectAll(string $table_name): Array | null{

        if(!$this->validatePDO()){
            return null;
        }
        
        try {
            $query = $this->pdo->prepare("select * from {$table_name}");
            $result = $query->execute();
            if($result){
                $result = $query->fetchAll(PDO::FETCH_ASSOC); // Is better get an associative array of each record
            }
            $query->closeCursor();
            return $result;
        } catch (PDOException $error) {
            //echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            $logger = Injector::get("logger");
            $logger->addAppErrorLog($error);
            Injector::set($logger, "logger");
            return null;
        }
        // https://www.php.net/manual/es/pdo.connections.php
        // This doc says that PHP will close the connections automatically when the script ends, also is possible do it to reference the variable to null (pdo and stat)
    }

    // INSERT
    /**
     * This function INSERT a new record on a table, returns a bool acording the result of the operation
     * @param string $table_name is the name of the table in the database
     * @param array $data is the associative array that must contains the name of the fields and his values to make the insert operation
     * @return bool true if the operations was succesful, else return false
    */
    public function create(string $table_name, array $data): bool{

        if(!$this->validatePDO()){
            return false;
        }

        // Get the fields names and the values of the table
        $fields = implode(", ", array_keys($data));
        $values = array_values($data);
        $wildcards = implode(", ", array_fill(0, count($values), "?")); // Generate the wildcards according the number of the fields to give values

        try {
            $query = $this->pdo->prepare("insert into {$table_name} ({$fields}) values ($wildcards)");
            $result = $query->execute($values);
            $query->closeCursor();
            return $result;
        } catch (PDOException $error) {
            //echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            AppLogger::addAppErrorLog("Error to create a resource by: {$error}");
            return false;
        }
    }
    // SELECT ONE
    /**
     * This function get an specific record on a table accordin his id (THIS FUNCTION ONLY RETURN ONE RECORD)
     * @param string $table_name is the name of the table in the database
     * @param string $id_name is the name of the key to make the filter
     * @param string|int $id is the id value of the record to do the filter (where) according the $id_name
     * @return array|null return an array that contain the record if exists, else, return null
    */
    public function selectOne(string $table_name, string $id_name, string | int $id): Array | null{

        if(!$this->validatePDO()){
            return null;
        }
        
        try {
            $query = $this->pdo->prepare("select * from {$table_name} where {$id_name} = ? limit 1");
            $result = $query->execute([$id]);
            if($result){
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                $query->closeCursor();
            }
            return $result[0]; // ! THIS IS VERY IMPORTANT! RETURN THE ARRAY INSIDE THE ARRAY OF RESULTS!
        } catch (PDOException $error) {
            //echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            AppLogger::addAppErrorLog("Error to select one resource by: {$error}");
            return null;
        }
    }
    // UPDATE
    /**
     * This function update an specific record on the database according the data an his id of the record to make the filter (where)
     * @param string $table_name is the name of the table in the database
     * @param string|int $id is the id value of the record to do the filter (where) according the $id_name
     * @param string $id_name is the name of the key to make the filter
     * @param array $data must be the associative array to update the specific fields of the record
     * @return bool|null return true if the operations was succesful, else return faklase or null
    */
    public function updateOne(string $table_name, string | int $id, string $id_name, Array $data) : bool | null{

        if(!$this->validatePDO()){
            AppLogger::addAppErrorLog("PDO CONNECTION IS NULL");
            return false;
        }

        $fields = array_keys($data); // Get the fields name of the table - model
        $values = array_values($data); // Get the values of the query to the model

        // Add the wild card for each field and covernt it in a string with the " " separator
        $wildcards = implode(", ", array_map(fn ($field) => $field . " = ?", $fields));

        try {
            $query = $this->pdo->prepare("update {$table_name} set {$wildcards} where {$id_name} = $id");
            $result = $query->execute($values);
            $query->closeCursor();
            return $result;
        } catch (PDOException $error) {
            //echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            AppLogger::addAppErrorLog("Error to update the resource by: {$error}");
            return null;
        }
    }
    // DELETE
    /**
     * This function DELETE an specific record on the database according the data an his id of the record to make the filter (where)
     * @param string $table_name is the name of the table in the database
     * @param string|int $id is the id value of the record to do the filter (where) according the $id_name
     * @param string $id_name is the name of the key to make the filter
     * @return bool|null return true if the operations was succesful, else return faklase or null
    */
    public function delete(string $table_name, string | int $id, string $id_name) : bool | null{

        if(!$this->validatePDO()){
            return false;
        }

        try {
            $query = $this->pdo->prepare("delete from {$table_name} where {$id_name} = ?");
            $result = $query->execute([$id]);
            $query->closeCursor();
            return $result;
        } catch (PDOException $error) {
            //echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            AppLogger::addAppErrorLog("Error to delete the resource by: {$error}");
            return null;
        }
    }

    /**
     * This function is that make personalized querys or also named raw query, for example store procedures. This function return the answer according his parameters:
     * @param string $query is the string SQL query to do in the database (MUST BE CONTAIN WILDCARDS, else returns an exception)
     * @param array $values is array with the values to do the prepare query and the operation
     * @param bool $wait_models is the flag to return any model or no, default it's false and only return a bool answer if the query operations was succesful, else return false, but if the parameters will pased with a true value, then
     * this will do the query operation and if the query was succesful and return any record, the return that answer
     * @return array|bool true if the query operation was succesful, else return false or return an array that contains the records result of the operations (according the $wait_models parameter)
    */
    public function ownQuery(string $query, Array $values, bool $wait_models = false): Array | bool{

        if(!$this->validatePDO()){
            return false;
        }

        if(empty($values)){
            return throw new Exception("NO SE ACEPTAN ARREGLOS VACIOS COMO VALORES en la función ownQuery de la clase QueryBuilder", 1);
        }
        if(empty($query)){
            return throw new Exception("NO SE ACEPTAN CONSULTAS VACIAS en la función ownQuery de la clase QueryBuilder", 1);
        }
        if(!str_contains($query, "?")){
            return throw new Exception("NO SE ACEPTAN CONSULTAS SIN COMODINES de tipo ? en la función ownQuery de la clase QueryBuilder", 1);
        }

        $getModels = false;

        if(str_contains($query, "SELECT")){
            $getModels = true;
        }

        if($wait_models){
            $getModels = true;
        }

        $result = null;

        try {

            $query = $this->pdo->prepare($query);
            $result = $query->execute($values);
            
            if($getModels){
                $result = $query->fetchAll(PDO::FETCH_ASSOC); // Return how a associative array   
            }
            
            $query->closeCursor();

        } catch (PDOException $error) {
            //echo $error;
            AppLogger::addAppErrorLog("Error to try call the own query by: {$error}");
            $result = false;
        }
        return $result;
    }

    /**
     * This function validte if the pdo proprety is null (to validate the state of the connection)
     * @return bool true if the connection is active, else return false
    */
    private function validatePDO(){
        return $this->pdo != null;
    }

}