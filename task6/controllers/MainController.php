<?php



class MainController extends TwigBaseController
{
    public $template = "main.twig";
    public $title = "Home";


    public function GetContext(): array
    {
        $context = parent::GetContext();

        $query = $this->pdo->prepare("SELECT id, title, image FROM characters");
        $query->execute();

        $context['characters'] = $query->fetchAll(PDO::FETCH_ASSOC);

        return $context;
    }
}
