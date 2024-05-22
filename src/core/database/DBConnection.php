<?php
namespace Jdev2\TodoApp\core\database;

use PDO;
use PDOException;
use Jdev2\TodoApp\core\utils\AppLogger;
/**
 * This class represents the database connection
*/
class DBConnection{
    /**
     * This function try the connection with the database, if it's succesful, return an PDO object, else, return null
     * @param array $config is the array that contains the paramertes to do the connection
     * @return PDO|null return a PDO object if the connections is succesful, else, return null
    */
    public static function ConnectDB(Array $config) : PDO | null{
        try {
            $pdo = new PDO("{$config['sgbd']}:host={$config['host']}:{$config['port']};dbname={$config['name']}", "{$config['user']}", "{$config['password']}");
            return $pdo;
        } catch (PDOException $error) {
            //echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            AppLogger::addAppErrorLog($error);
            return null;
        }
    }

    /**
     * This function CLOSE manually a PDO conection by reference
     * @param PDO $pdo by reference is the PDO instance to will be closed
    */
    public static function CloseConnection(PDO &$pdo): void{
        $pdo = null;
    }
}