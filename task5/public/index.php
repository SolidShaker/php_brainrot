<?php


require_once '../vendor/autoload.php';


$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader);


$url = $_SERVER["REQUEST_URI"];

$title = "";
$template = "";


$context = [];


if ($url == "/")
{
    $title = "Home";
    $template = "main.twig";
} 
elseif (preg_match("#/aizen#", $url))
{
    $title = "Aizen";
    $template = "__character.twig";
    
    $context['image'] = "/images/aizen.gif";
}
elseif (preg_match("#/madara#", $url))
{
    $title = "Madara";
    $template = "__character.twig";

    $context['image'] = "/images/madara.gif";
}

$context["title"] = $title;

echo $twig->render($template, $context);

?>