<?php


class BaseCharacterTwigController extends TwigBaseController
{
    public function GetContext(): array
    {
        $context = parent::GetContext();

        $query = $this->pdo->query("
            SELECT DISTINCT t.type 
            FROM characters_types t 
            ORDER BY 1"
        );
        $types = $query->fetchAll();
        $context['types'] = $types;

        return $context;
    }
}
