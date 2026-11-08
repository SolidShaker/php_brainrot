<?php




class Controller404 extends BaseCharacterTwigController
{
    public $template = "404.twig"; 
    public $title = "Page not found";
    

    public function Get()
    {
        http_response_code(404); 
        parent::get();
    }
}