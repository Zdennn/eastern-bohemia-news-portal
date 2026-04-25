<?php

mb_internal_encoding("UTF-8");//nastaví UTF-8 pro všechny stránky

spl_autoload_register(function ($class){

    $path = explode("\\", $class);
    $path[0] = strtolower($path[0]);
    $filePath = join("/", $path) . ".php";

    if (file_exists($filePath)) {
        require_once($filePath);
    }
    
});

session_start();

$router = new \Controller\RouterController();
$router->zpracuj(array($_SERVER['REQUEST_URI']));