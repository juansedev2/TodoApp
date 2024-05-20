<?php
namespace Jdev2\TodoApp\core\security;

/***
 * This class provides the functions to get the necessary data of the clients for security
*/
class DataClientHandler{

    /**
     * This function returns the connection info of a client connection in a string that contains the infor
     * @return string the string of contains the connection client information
    */
    public static function getClientInfo() : string{
        return "Client connection - ip: " . static::getClientIp() . " - hostname: " . static::getClientHost() . ".";
    }

    /**
     * THis function get the ip of the client connection
     * @return string the string of the client ip
    */
    private static function getClientIp(): string{
        return $_SERVER["REMOTE_ADDR"];
    }
    /**
     * THis function get the hostname of the client
     * @return string the string of the hostname of the cliente basaded in his ip
    */

    private static function getClientHost() : string{
        return gethostbyaddr(static::getClientIp());
    }
    
}