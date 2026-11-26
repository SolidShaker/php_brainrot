<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../framework/autoload.php";


require_once __DIR__ . "/../controllers/BaseCharacterTwigController.php";

require_once __DIR__ . "/../controllers/Controller404.php"; 

require_once __DIR__ . "/../controllers/MainController.php"; 
require_once __DIR__ . "/../controllers/ObjectController.php"; 

require_once __DIR__ . "/../controllers/SearchController.php";
require_once __DIR__ . "/../controllers/CharacterObjectCreateController.php";
require_once __DIR__ . "/../controllers/CharacterTypeCreateController.php";
require_once __DIR__ . "/../controllers/CharacterObjectDeleteController.php";
require_once __DIR__ . "/../controllers/CharacterObjectUpdateController.php";



$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views');
$twig = new \Twig\Environment($loader, [
    "debug" => true 
]);
$twig->addExtension(new \Twig\Extension\DebugExtension()); 



$database = new Database();


$router = new Router($twig, $database->pdo);

$router->Add("/search", SearchController::class);
$router->Add("/create/character", CharacterObjectCreateController::class);
$router->Add("/create/type", CharacterTypeCreateController::class);
$router->Add("/characters/(?P<id>\d+)/delete", CharacterObjectDeleteController::class);
$router->Add("/characters/(?P<id>\d+)/edit", CharacterObjectUpdateController::class);

$router->Add('/', MainController::class);
$router->Add("/characters/(?P<id>\d+)", ObjectController::class);

$router->GetOrDefault(Controller404::class);

