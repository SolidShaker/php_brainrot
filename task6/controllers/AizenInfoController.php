<?php
require_once "AizenController.php";




class AizenInfoController extends AizenController
{
    public $template = "info.twig";
    
        
    public function GetContext(): array
    {
        $context = parent::GetContext();

        $context["info"] = "You are here... As planned.";
        $context["active"] = "info";
        
        return $context;
    }
    
}

?>