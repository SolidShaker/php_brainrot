<?php
require_once "MadaraController.php";




class MadaraInfoController extends MadaraController
{
    public $template = "info.twig";
    
        
    public function GetContext(): array
    {
        $context = parent::GetContext();

        $context["info"] = "Do you wanna dance?..";
        $context["active"] = "info";
        
        return $context;
    }
}

?>