<?php
require_once "../vendor/autoload.php";
require_once "../framework/autoload.php";


require_once "../controllers/BaseCharacterTwigController.php";

require_once "../controllers/SearchController.php";
require_once "../controllers/Controller404.php"; 

require_once "../controllers/MainController.php"; 
require_once "../controllers/ObjectController.php"; 




$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
    "debug" => true 
]);
$twig->addExtension(new \Twig\Extension\DebugExtension()); 



$database = new Database();


$router = new Router($twig, $database->pdo);

$router->Add("/search", SearchController::class);

$router->Add('/', MainController::class);
$router->Add("/characters/(?P<id>\d+)", ObjectController::class);

$router->GetOrDefault(Controller404::class);

