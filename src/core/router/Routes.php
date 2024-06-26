<?php
//This file contains the routes of the app
return [
    "" => ["HomeController", "showLanding"],
    "inicio" => ["HomeController", "showLanding"],
    "/" => ["HomeController", "showLanding"],
    "registro" => ["HomeController", "showRegister"],
    "register" => ["UserController", "createUser"],
    "acerca" => ["HomeController", "showAbout"],
    "modo-invitado" => ["HomeController", "showGuestMode"],
    "iniciar-sesion" => ["HomeController", "showLoginForm"],
    "login" => ["LoginController", "tryLogin"],
    "loginError" => ["LoginController", "showLoginError"],
    "welcome" => ["LoginController", "showWelcome"],
    "cerrar-sesion" => ["LoginController", "closeSession"],
    "actualizar-tarea-form" => ["TaskController", "showUpdateTaskView"],
    "update-task" => ["TaskController", "updateTask"],
    "create-task" => ["TaskController", "createTask"],
    "eliminar-tarea" => ["TaskController", "deleteTask"],
    "NoEncontrado" => ["ExceptionController", "returnNotFoundView"],
    "GeneralError" => ["ExceptionController", "returnInternalServerErrorView"]
];