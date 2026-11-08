<?php


class ObjectController extends BaseCharacterTwigController
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

        $query = $this->pdo->prepare(
            "SELECT id, title, description, image FROM characters WHERE id = :id"
        );
        $query->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $query->execute();
        
        $character = $query->fetch(PDO::FETCH_ASSOC);

        if (!$character)
        {
            $context['error'] = "Character not found.";
            return $context;
        }

        $context['character'] = $character;

        
        $show = $_GET['show'] ?? null;

        if ($show == 'image')
        {
            $this->template  = "image.twig";
            $this->title     = "{$character['title']} - Image";
            $context['flag'] = 'image';

            if (empty($character['image']))
                $context['error'] = 'No image available for this character.';
        } 
        elseif ($show == 'info')
        {
            $this->template  = "info.twig";
            $this->title     = "{$character['title']} - Info";
            $context['flag'] = 'info';
        }
        else 
        {
            $this->template  = "__character.twig";
            $this->title     = "{$character['title']} - Category";
            $context['flag'] = "None";
        }

        return $context;
    }
}
