<?php
namespace Jdev2\TodoApp\core\utils;

use Monolog\Level;
use Monolog\Logger;
use Jdev2\TodoApp\core\Injector;
use Monolog\Handler\StreamHandler;
use Jdev2\TodoApp\core\utils\DateHandler;
use Jdev2\TodoApp\core\security\DataClientHandler;

class AppLogger{

    private static string $log_dir = "";

    public static function initAppLogger(){
        static::$log_dir = Injector::get("app-route") . "/logs/";
    }

    public static function addAppErrorLog(string $error){
        $loginString = $error . " at: " . DateHandler::getCurrentlyDateString();
        // Create the logger
        $logger = new Logger('ErrorAppLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler( static::$log_dir .'ErrorApplog.log', Level::Error));
        // You can now use your logger
        $logger->error($loginString);
    }

    public static function addTryLoginLog(){
        // First, get the client info
        $connection_client_info = DataClientHandler::getClientInfo();
        $loginString = $connection_client_info . " try a login at " . DateHandler::getCurrentlyDateString();
        // Create the logger
        $logger = new Logger('tryLoginUserLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler( static::$log_dir .'TryLoginUserlog.log', Level::Info));
        // You can now use your logger
        $logger->info($loginString);
    }

    public static function addSucLoginLog(string $email){
        // First, get the client info
        $connection_client_info = DataClientHandler::getClientInfo();
        $loginString = $connection_client_info . " - email: {$email} logged at " . DateHandler::getCurrentlyDateString();
        // Create the logger
        $logger = new Logger('SuccessfulLoginUserLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler( static::$log_dir .'SuccesfulLoginUserlog.log', Level::Info));
        // You can now use your logger
        $logger->info($loginString);
    }

    public static function addClientConnectionLog(){
        $connection_client_info = DataClientHandler::getClientInfo();
        $loginString = $connection_client_info . " get ". static::getResourceURI() . " resource at: " . DateHandler::getCurrentlyDateString();
        // Create the logger
        $logger = new Logger('ClientConnectionLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler(static::$log_dir .'ClientConnectionLog.log', Level::Notice));
        // You can now use your logger
        $logger->notice($loginString);
    }

    public static function addClientActionsLog(string $client_action_string){
        $connection_client_info = DataClientHandler::getClientInfo();
        $loginString = $connection_client_info . " do the action: " . $client_action_string;
        // Create the logger
        $logger = new Logger('ClientActionsLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler( static::$log_dir .'ClientActionsLog.log', Level::Notice));
        // You can now use your logger
        $logger->notice($loginString);
    }

    private static function getResourceURI() : string{
        if(empty($_SERVER["PATH_INFO"])){
            return $_SERVER["REQUEST_URI"];
        }else{
            return $_SERVER["PATH_INFO"];
        }

    }

}