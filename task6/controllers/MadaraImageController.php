<?php
require_once "MadaraController.php";




class MadaraImageController extends MadaraController
{
    public $template = "image.twig";
    
        
    public function GetContext(): array
    {
        $context = parent::GetContext();

        $context["image"] = "/images/madara.gif";
        $context["active"] = "image";
        
        return $context;
    }
}

?>