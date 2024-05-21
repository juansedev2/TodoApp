<?php
namespace Jdev2\TodoApp\core\database;

use PDO;
use PDOException;
use Jdev2\TodoApp\core\utils\AppLogger;

class DBConnection{

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

    // It's necessary to pass the pdo by reference, NOR FOR VALUE (alter a copy? no...)
    public static function CloseConnection(PDO &$pdo): void{
        $pdo = null;
    }
}