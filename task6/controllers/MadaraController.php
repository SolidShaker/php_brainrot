<?php
require_once "TwigBaseController.php";


class MadaraController extends TwigBaseController
{
    public $title = "Madara";
    public $template = "__character.twig";
    

    public function GetContext(): array
    {
        $context = parent::GetContext();

        $context["character"] = "madara";
        
        return $context;
    }
}

?>