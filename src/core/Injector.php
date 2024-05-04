<?php

// This class is the dependency injector of the APP
class Injector{

    /**
     * @var array $dependencies is the array that the Injector uses to save the all dependecies of the App 
    */
    private static array $dependencies;
    
    public static function set(mixed $value, string $name){
        Injector::$dependencies["{$name}"] = $value;
    }

    public static function get(string $name){
        if(array_key_exists($name, Injector::$dependencies)){
            return Injector::$dependencies["{$name}"];
        }
    }

}