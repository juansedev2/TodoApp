<?php
namespace Jdev2\TodoApp\core\helpers;

class InputValidator{

    /**
     * This funcition validate all of the strings in the array and if someone is empty, then return false
    */
    public static function validateAllEmptyStrings(Array $strings){
        foreach($strings as $string){
            if(empty($string)){
                return false;
            }
        }
        return true;
    }
}