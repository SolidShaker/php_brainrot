<?php


class ObjectInfoController extends TwigBaseController
{
    public $template = "info.twig";
    public $title = "Character Information";




    public function GetContext(): array
    {
        $context = parent::GetContext();

        $id = $this->params['id'] ?? null;

        if (!$id || !is_numeric($id))
        {
            $context['error'] = "Invalid Character ID";
            return $context;
        }

        $query = $this->pdo->prepare(
            "SELECT id, title, description FROM characters WHERE id = :id"
        );
        $query->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $query->execute();

        $character = $query->fetch(PDO::FETCH_ASSOC);

        if (!$character)
        {
            $context['error'] = "Character information not found.";
            return $context;
        }

        $context['character'] = $character;
        $context['flag'] = 'info';
        $context['title'] = "{$character['title']} - Info";

        return $context;
    }
}