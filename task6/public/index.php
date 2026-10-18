<?php
require_once "../vendor/autoload.php";

require_once "../controllers/MainController.php";

require_once "../controllers/AizenController.php";
require_once "../controllers/AizenImageController.php";
require_once "../controllers/AizenInfoController.php";

require_once "../controllers/MadaraController.php";
require_once "../controllers/MadaraImageController.php";
require_once "../controllers/MadaraInfoController.php";

require_once "../controllers/Controller404.php"; // added



$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader);


$url = $_SERVER["REQUEST_URI"];

$context = [];
$controller = null;

$controller = new Controller404($twig); 


if ($url == "/")
{
    $controller = new MainController($twig);
}

elseif (preg_match("#^/aizen/info#", $url))
{
    $controller = new AizenInfoController($twig);    
}
elseif (preg_match("#^/aizen/image#", $url))
{
    $controller = new AizenImageController($twig);                
}
elseif (preg_match("#^/aizen#", $url))
{
    $controller = new AizenController($twig);
}

elseif (preg_match("#^/madara/info#", $url))
{
    $controller = new MadaraInfoController($twig);    
}
elseif (preg_match("#^/madara/image#", $url))
{
    $controller = new MadaraImageController($twig);                
}
elseif (preg_match("#^/madara#", $url))
{
    $controller = new MadaraController($twig);    
}

if ($controller)
{
    $controller->get();    
}

?>