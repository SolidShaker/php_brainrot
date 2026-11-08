<?php


class BaseCharacterTwigController extends TwigBaseController
{
    public function GetContext(): array
    {
        $context = parent::GetContext();

        $query = $this->pdo->query("SELECT DISTINCT type FROM characters ORDER BY 1");
        $types = $query->fetchAll();
        $context['types'] = $types;

        return $context;
    }
}