<?php
session_start();

if (!file_exists(DB_INI_FILE) && !file_exists(BACKUP_FILE)) {
    header('Location: '.HARDCODED_URL.'errors/error_main.php');
    exit;
}

$routes = require 'configs/routes.php';
$default_route = $routes['default'];

$route_parts = explode('/', $default_route);

// Récupération des termes de la route de l’utilisateur
$method = $_SERVER['REQUEST_METHOD'];
$a = $_REQUEST['a']??$route_parts[1];
$r = $_REQUEST['r']??$route_parts[2];

// Vérification que la route demandée est dans la liste des routes de l’app.
if (!in_array($method . '/' . $a . '/' . $r, $routes)) {
    die('Ce que vous cherchez n’est pas ici');
}

// Si la route demandée est dans la liste, on importe le controleur adéquat
$controllerName = 'Controllers\\' . ucfirst($r);
$controller =  new $controllerName();

// Enfin, on exécute la fonction adéquate du controleur chargé
$data = call_user_func([$controller, $a]);
