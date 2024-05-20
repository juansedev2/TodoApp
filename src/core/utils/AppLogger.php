<?php
namespace Jdev2\TodoApp\core\utils;

use Monolog\Level;
use Monolog\Logger;
use Jdev2\TodoApp\core\Injector;
use Monolog\Handler\StreamHandler;
use Jdev2\TodoApp\core\utils\DateHandler;
use Jdev2\TodoApp\core\security\DataClientHandler;

class AppLogger{

    private string $log_dir;

    public function __construct(string $log_dir){
        $this->log_dir = $log_dir;
    }

    public function addErrorLog(string $error){
        $loginString = $error . " at: " . DateHandler::getCurrentlyDateString();
        // Create the logger
        $logger = new Logger('ErorAppLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler( $this->log_dir .'ErorApplog.log', Level::Error));
        // You can now use your logger
        $logger->info($loginString);

    }

    public function addTryLoginLog(){
        // First, get the client info
        $connection_client_info = DataClientHandler::getClientInfo();
        $loginString = $connection_client_info . " try a login at " . DateHandler::getCurrentlyDateString();
        // Create the logger
        $logger = new Logger('tryLoginUserLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler( $this->log_dir .'TryLoginUserlog.log', Level::Info));
        // You can now use your logger
        $logger->info($loginString);
    }

    public function addSucLoginLog(string $username, string $email){
        // First, get the client info
        $connection_client_info = DataClientHandler::getClientInfo();
        $loginString = $connection_client_info . " - User name: {$username} - email: {$email} logged at " . DateHandler::getCurrentlyDateString();
        // Create the logger
        $logger = new Logger('SuccessfulLoginUserLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler( $this->log_dir .'SuccesfulLoginUserlog.log', Level::Debug));
        // You can now use your logger
        $logger->info($loginString);
    }

    public function addClientConnectionLog(){
        $connection_client_info = DataClientHandler::getClientInfo();
        $loginString = $connection_client_info . " get ". $this->getResourceURI() . " resource at: " . DateHandler::getCurrentlyDateString();
        // Create the logger
        $logger = new Logger('ClientConnectionLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler($this->log_dir .'ClientConnectionLog.log', Level::Notice));
        // You can now use your logger
        $logger->notice($loginString);
    }

    public function addClientActionsLog(string $client_action_string){
        $connection_client_info = DataClientHandler::getClientInfo();
        $loginString = $connection_client_info . " do the action: " . $client_action_string;
        // Create the logger
        $logger = new Logger('ClientActionsLog'); // Identificator of the log file
        $logger->pushHandler(new StreamHandler( $this->log_dir .'ClientActionsLog.log', Level::Notice));
        // You can now use your logger
        $logger->notice($loginString);
        
    }

    private function getResourceURI() : string{
        if(empty($_SERVER["PATH_INFO"])){
            return $_SERVER["REQUEST_URI"];
        }else{
            return $_SERVER["PATH_INFO"];
        }

    }

}