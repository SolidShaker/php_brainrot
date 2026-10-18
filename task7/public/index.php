<?php


require_once '../vendor/autoload.php';


$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader);


$url = $_SERVER["REQUEST_URI"];

$title = "";
$template = "";


$context = [];
$menu = [ 
    [
        "title" => "Home",
        "url" => "/",
    ],
    [
        "title" => "Aizen",
        "url" => "/aizen",
    ],
    [
        "title" => "Madara",
        "url" => "/madara",
    ]
];


if ($url == "/")
{
    $title = "Home";
    $template = "main.twig";
} 
elseif (preg_match("#/aizen#", $url))
{
    $title = "Aizen";
    $template = "image.twig";
    
    $context['image'] = "/images/aizen.gif";
}
elseif (preg_match("#/madara#", $url))
{
    $title = "Madara";
    $template = "image.twig";

    $context['image'] = "/images/madara.gif";
}

$context["title"] = $title;
$context["menu"]  = $menu;

echo $twig->render($template, $context);

?>