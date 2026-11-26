<?php




class MainController extends BaseCharacterTwigController
{
    public $template = "main.twig";
    public $title = "Home";


    public function GetContext(): array
    {
        $context = parent::GetContext();

        if (isset($_GET['type']))
        {
            $query = $this->pdo->prepare(
                "SELECT c.* 
                FROM characters c
                JOIN characters_types t ON t.id = c.type_id
                WHERE t.type = :type"
            );
            $query->bindValue(':type', $_GET['type']);
            $query->execute();
        } else {
            $query = $this->pdo->query("SELECT * FROM characters");
        }

        $context['characters'] = $query->fetchAll(PDO::FETCH_ASSOC);

        return $context;
    }
}

