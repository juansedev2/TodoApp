<?php
namespace Jdev2\TodoApp\core\utils;

use Monolog\Level;
use Monolog\Logger;
use Jdev2\TodoApp\core\Injector;
use Monolog\Handler\StreamHandler;
use Jdev2\TodoApp\core\utils\DateHandler;
use Jdev2\TodoApp\core\security\DataClientHandler;
/**
 * This class is the logger of the app, it's will be used to makes easier the log process
*/
class AppLogger{

    /**
     * @property string $log_dir is the directory path of the logs
    */
    private static string $log_dir = "";

    /**
     * !This function inits the app logger, getting the logger app and this function always will be call first instead any logger functions
    */
    public static function initAppLogger(){
        static::$log_dir = Injector::get("app-route") . "/logs/";
    }
    /**
     * This function add a error message in the log error file
     * @param string $error is the message of the error to be added in the ErrorAppLog
    */
    public static function addAppErrorLog(string $error){
        $loginString = $error . " at: " . DateHandler::getCurrentlyDateString();
        // Create the logger
        $logger = new Logger('ErrorAppLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler( static::$log_dir .'ErrorApplog.log', Level::Error));
        // You can now use your logger
        $logger->error($loginString);
    }
    /**
     * This function add the try login actions of the client with his data
    */
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
    /**
     * This function add the succesful try login of a user
     * @param string $email is the email of the client that has the succesful login
    */
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
    /**
     * This function add the client connection log, it has the resource and the data of the client, that resource the client asked
    */
    public static function addClientConnectionLog(){
        $connection_client_info = DataClientHandler::getClientInfo();
        $loginString = $connection_client_info . " get ". static::getResourceURI() . " resource at: " . DateHandler::getCurrentlyDateString();
        // Create the logger
        $logger = new Logger('ClientConnectionLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler(static::$log_dir .'ClientConnectionLog.log', Level::Notice));
        // You can now use your logger
        $logger->notice($loginString);
    }
    /**
     * This function add an specific actions of a client in the app, for examples crud resources or others actions that will be stored in the log
     * @param string $client_action_string is the description of the client action to will be stored in the log
    */
    public static function addClientActionsLog(string $client_action_string){
        $connection_client_info = DataClientHandler::getClientInfo();
        $loginString = $connection_client_info . " do the action: " . $client_action_string;
        // Create the logger
        $logger = new Logger('ClientActionsLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler( static::$log_dir .'ClientActionsLog.log', Level::Notice));
        // You can now use your logger
        $logger->notice($loginString);
    }
    /**
     * This function returns the web resources that the client asked
     * @return string return the currently web resource of the client asked
    */
    private static function getResourceURI() : string{
        if(empty($_SERVER["PATH_INFO"])){
            return $_SERVER["REQUEST_URI"];
        }else{
            return $_SERVER["PATH_INFO"];
        }

    }

}