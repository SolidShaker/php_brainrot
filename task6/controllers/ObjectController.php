<?php


class ObjectController extends TwigBaseController
{
    public $template = "__character.twig"; 
    public $title = "Character Details";




    public function GetContext(): array
    {
        $context = parent::GetContext();
        
        $id = $this->params['id'] ?? null; 
        if (!$id || !is_numeric($id))
        {
            $context['error'] = "Invalid character ID";
            return $context;
        }

        $query = $this->pdo->prepare("SELECT id, title FROM characters WHERE id = :id");
        $query->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $query->execute();
        
        $character = $query->fetch(PDO::FETCH_ASSOC);

        if (!$character)
        {
            $context['error'] = "Character not found.";
            return $context;
        }

        $context['character'] = $character;
        $context['flag'] = 'None';
        $context['title'] = "{$character['title']} - Category";

        return $context;
    }
}
