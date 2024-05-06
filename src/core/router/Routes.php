<?php
//This file contains the routes of the app
return [
    "" => ["HomeController", "showLanding"],
    "/" => ["HomeController", "showLanding"],
    "login" => ["LoginController", "loginUser"]
];