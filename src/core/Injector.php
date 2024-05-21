<?php
namespace Jdev2\TodoApp\core;
// This class is the dependency injector of the APP
class Injector{

    /**
     * @property array $dependencies is the array that the Injector uses to save the all dependecies of the App 
    */
    private static array $dependencies;
    
    /**
     * This function store a new dependecie in the injector.
     * Warning: if it's assigned an existing name of a dependence, then this function overwrite this dependence with the last value assigned
     * @param mixed $value is the variable|oject|value to store in the injector
     * @param string $name is the name of the dependence
    */
    public static function set(mixed $value, string $name){
        Injector::$dependencies["{$name}"] = $value;
    }

    /**
     * This function return an existing depedendecie injected before, if the key $name doesn't exists, then this function returns null
     * @param mixed $value is the variable|oject|value to store in the injector
    */
    public static function get(string $name){
        if(array_key_exists($name, Injector::$dependencies)){
            return Injector::$dependencies["{$name}"];
        }else{
            return null;
        }
    }

}