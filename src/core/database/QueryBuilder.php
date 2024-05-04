<?php

// This class is the QueryBuilder of the app that makes the queries with the DB
class QueryBuilder{

    public function __construct(private PDO $pdo){}

    // CRUD OPERATIONS
    // SELECT
    public function selectAll(string $table_name): Array | null{
        try {
            $query = $this->pdo->prepare("select * from {$table_name}");
            $result = $query->execute();
            if($result){
                $result = $query->fetchAll(PDO::FETCH_ASSOC); // Is better get an associative array of each record
            }
            return $result;
        } catch (PDOException $e) {
            echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            return null;
        }
        // https://www.php.net/manual/es/pdo.connections.php
        // This doc says that PHP will close the connections automatically when the script ends, also is possible do it to reference the variable to null (pdo and stat)
    }

    // INSERT
    public function create(string $table_name, array $data): bool{

        // Get the fields names and the values of the table
        $fields = implode(", ", array_keys($data));
        $values = array_values($data);
        $wildcards = implode(", ", array_fill(0, count($values), "?")); // Generate the wildcards according the number of the fields to give values

        try {
            $query = $this->pdo->prepare("insert into {$table_name} ({$fields}) values ($wildcards)");
            $result = $query->execute($values);
            
            return $result;
        } catch (PDOException $e) {
            echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            return false;
        }
    }

    // SELECT ONE
    public function selectOne(string $table_name, string $id_name, string | int $id): Array | null{
        try {
            $query = $this->pdo->prepare("select * from {$table_name} where {$id_name} = ? limit 1");
            $result = $query->execute([$id]);
            if($result){
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $result[0]; // ! THIS IS VERY IMPORTANT! RETURN THE ARRAY INSIDE THE ARRAY OF RESULTS!
        } catch (PDOException $e) {
            echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            return null;
        }
    }

    // UPDATE
    public function updateOne(string $table_name, string | int $id, string $id_name, Array $data){

        $fields = array_keys($data); // Get the fields name of the table - model
        $values = array_values($data); // Get the values of the query to the model

        // Add the wild card for each field and covernt it in a string with the " " separator
        $wildcards = implode(", ", array_map(fn ($field) => $field . " = ?", $fields));

        try {
            $query = $this->pdo->prepare("update {$table_name} set {$wildcards} where {$id_name} = $id");
            $result = $query->execute($values);
            return $result;
        } catch (PDOException $e) {
            echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            return null;
        }
    }

    // DELETE
    public function delete(string $table_name, string | int $id, string $id_name){

        try {
            $query = $this->pdo->prepare("delete from {$table_name} where {$id_name} = ?");
            $result = $query->execute([$id]);
            return $result;
        } catch (PDOException $e) {
            echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            return null;
        }
    }
}