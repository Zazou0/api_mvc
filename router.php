<?php

spl_autoload_register(function($class){
    include($class . ".php");
});

preg_match_all("#\/([a-zA-Z]*)\/?([0-9]*)#", $_SERVER['REQUEST_URI'], $match);

$method = $_SERVER["REQUEST_METHOD"];

$id = intval($match[2][0]);

$controllerName = "\\Controller\\" . ucfirst($match[1][0]) . "Controller";

$controller = new $controllerName();

header("Content-Type: application/json");


switch ($method) {
    case "GET";
        if ($id != 0) {
            echo $controller->getOne($id);
        } else {
            echo $controller->getAll();
        }
        break;
    case "POST";
        echo $controller->create();
        break;
    case "PUT";
        echo $controller->update($id);
        break;
    case "DELETE";
        echo $controller->delete($id);
        break;
}