<?php
//This file contains the routes of the app
return [
    "" => ["HomeController", "showLanding"],
    "/" => ["HomeController", "showLanding"],
    "registro" => ["HomeController", "showRegister"],
    "acerca" => ["HomeController", "showAbout"],
];