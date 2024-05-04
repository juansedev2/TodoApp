<?php

class Handler{

    /**
     * This class only do cleaning of the url request
    */
    public static function handleRequest(){
        return trim($_SERVER["REQUEST_URI"], "/");
    }
}