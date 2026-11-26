<?php
require_once "BaseController.php";


class TwigBaseController extends BaseController
{
    public $title = "";
    public $template = "";
    protected \Twig\Environment $twig;

    public function SetTwig($twig)
    {
        $this->twig = $twig;
    }
    
    public function GetContext(): array
    {
        $context = parent::GetContext();
        
        return $context;
    }

    public function GET(array $context) 
    {
        $context["title"] = $this->title;        
        echo $this->twig->render($this->template, $context);
    }
}

