<?php
// ! This files init the important configurations of the app
use Jdev2\TodoApp\core\Injector;
use Jdev2\TodoApp\core\database\DBConnection;
use Jdev2\TodoApp\core\database\QueryBuilder;
use Jdev2\TodoApp\core\utils\AppLogger;

$APP_PATH = $_SERVER["DOCUMENT_ROOT"];
Injector::set($APP_PATH, "app-route");
Injector::set(require __DIR__ . "/config/Config.php", "config");

// Config the display of the server errors on the web browser if this isn't production
if(!Injector::get("config")["production"]){
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);
}else{
    error_reporting(0);
    ini_set("display_errors", 0);
    ini_set("display_startup_errors", 0);
}

date_default_timezone_set((require __DIR__ ."/config/Config.php")["time-zone"]); // Updathe the timezone to the app of the server
// Create the AppLogger and inject to depedences handler, also insert the first necessarylog
AppLogger::initAppLogger();
AppLogger::addClientConnectionLog();
Injector::set(new QueryBuilder(DBConnection::ConnectDB(Injector::get("config")["database"])), "querybuilder");

