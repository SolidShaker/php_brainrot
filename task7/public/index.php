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
        "url" => "/"
    ],
    [
        "title" => "Aizen",
        "url" => "/aizen",

        "image" => "/aizen/image",
        "info" => "/aizen/info"
    ],
    [
        "title" => "Madara",
        "url" => "/madara",

        "image" => "/madara/image",
        "info" => "/madara/info"
    ]
];


if ($url == "/")
{
    $title = "home";
    $template = "main.twig";
} 

elseif (preg_match("#^/aizen#", $url))
{
    $title = "Aizen";
    $template = "__character.twig";

    if (preg_match("#^/aizen/image#", $url))
    {
        $template = "image.twig";
        $context['image'] = "/images/aizen.gif";
        $context['active'] = 'image';
    }
    elseif (preg_match("#^/aizen/info#", $url))
    {
        $template = "info.twig";
        $context['info'] = "You are here... As planed.";
        $context['active'] = 'info';
    }
}

elseif (preg_match("#^/madara#", $url))
{
    $title = "Madara";
    $template = "__character.twig";

    if (preg_match("#^/madara/image#", $url))
    {
        $template = "image.twig";
        $context['image'] = "/images/madara.gif";
        $context['active'] = 'image';
    }
    elseif (preg_match("#^/madara/info#", $url))
    {
        $template = "info.twig";
        $context['info'] = "Wanna dance?..";
        $context['active'] = 'info';
    }
}

$context["title"] = $title;
$context["menu"]  = $menu;

echo $twig->render($template, $context);

?>