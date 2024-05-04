<?php

class DBConnection{

    public static function ConnectDB(Array $config) : PDO | null{
        try {
            $pdo = new PDO("{$config['sgbd']}:host={$config['host']}:{$config['port']};dbname={$config['name']}", "{$config['user']}", "{$config['password']}");
            //$pdo = new PDO('mysql:host=localhost;dbname=animesappdb', "root", "root");
            //echo "<b>Conexión exitosa</b><br/>";
            return $pdo;
        } catch (PDOException $e) {
            echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            return null;
        }
    }

    // It's necessary to pass the pdo by reference, NOR FOR VALUE (alter a copy? no...)
    public static function CloseConnection(PDO &$pdo): void{
        $pdo = null;
    }
}