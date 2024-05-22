<?php
/**
 * This function is used to debug, the use of the var_dump inside a die function
 * @param mixed $value is the variable to do the debug
*/
function dd(mixed $value){
    die(var_dump($value));
}