<?php



class ObjectImageController extends TwigBaseController
{
    public $template = "image.twig"; 
    public $title = "Character Image";




    public function GetContext(): array
    {
        $context = parent::GetContext();
        
        $id = $this->params['id'] ?? null;

        if (!$id || !is_numeric($id)) 
        {
            $context['error'] = "Invalid character ID.";
            return $context;
        }

        $query = $this->pdo->prepare(
            "SELECT id, title, image FROM characters WHERE id = :id"
        );
        $query->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $query->execute();
        
        $character = $query->fetch(PDO::FETCH_ASSOC);
        
        if (!$character || empty($character['image'])) 
        {
            $context['error'] = "No image available for this character.";
            return $context;
        }

        $context['character'] = $character;
        $context['flag'] = 'image';
        $context['title'] = "{$character['title']} - Image";

        return $context;
    }
}