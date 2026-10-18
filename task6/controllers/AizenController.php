<?php
require_once "TwigBaseController.php";


class AizenController extends TwigBaseController
{
    public $title = "Aizen";
    public $template = "__character.twig";
    

    public function GetContext(): array
    {
        $context = parent::GetContext();

        $context["character"] = "aizen";
        
        return $context;
    }
}

?>