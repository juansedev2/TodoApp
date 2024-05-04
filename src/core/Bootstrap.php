<?php
$APP_PATH = $_SERVER["DOCUMENT_ROOT"];
require_once $APP_PATH . "/core/functions/Functions.php";
require $APP_PATH . "/core/Injector.php";
require $APP_PATH . "/core/database/DBConnection.php";
require $APP_PATH . "/core/database/QueryBuilder.php";
// Models of the app
require $APP_PATH . "/app/models/Model.php";
require $APP_PATH . "/app/models/Serie.php";
// Router and routes
require $APP_PATH . "/core/router/Router.php";
require $APP_PATH . "/core/router/Handler.php";

Injector::set($APP_PATH, "app-route");
Injector::set(require __DIR__ . "/config/Config.php", "config");

// Config the display of the server errors on the web browser if this isn't production
if(!Injector::get("config")["production"]){
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);
}

//$pdo = DBConnection::ConnectDB(Injector::get("config")["database"]);
Injector::set(new QueryBuilder(DBConnection::ConnectDB(Injector::get("config")["database"])), "querybuilder");
//return new QueryBuilder($pdo);