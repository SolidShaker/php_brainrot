<?php
require_once "BaseController.php";


class TwigBaseController extends BaseController
{
    public $title = "";
    public $template = "";
    protected \Twig\Environment $twig;

    public function __construct(\Twig\Environment $twig)
    {
        $this->twig = $twig;
    }
    
    public function GetContext(): array
    {
        $context = parent::GetContext();
        $context["title"] = $this->title;        
        
        return $context;
    }

    public function Get() 
    {
        echo $this->twig->render($this->template, $this->GetContext());
    }
}



?>