<?php
require_once "AizenController.php";




class AizenImageController extends AizenController
{
    public $template = "image.twig";
    
        
    public function GetContext(): array
    {
        $context = parent::GetContext();

        $context["image"] = "/images/aizen.gif";
        $context["active"] = "image";
        
        return $context;
    }
}

?>