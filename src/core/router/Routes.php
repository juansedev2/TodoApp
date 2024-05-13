<?php
//This file contains the routes of the app
return [
    "" => ["HomeController", "showLanding"],
    "/" => ["HomeController", "showLanding"],
    "registro" => ["HomeController", "showRegister"],
    "acerca" => ["HomeController", "showAbout"],
    "modo-invitado" => ["HomeController", "showGuestMode"],
    "iniciar-sesion" => ["HomeController", "showLoginForm"],
    "login" => ["LoginController", "tryLogin"],
    "loginError" => ["LoginController", "showLoginError"],
    "welcome" => ["LoginController", "showWelcome"],
    "cerrar-sesion" => ["LoginController", "closeSession"],
    "actualizar-tarea-form" => ["TaskController", "showUpdateTaskView"],
    "update-task" => ["TaskController", "updateTask"]
];