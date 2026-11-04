<?php


abstract class BaseController 
{
    public PDO $pdo;
    public array $params;

    public function SetParams(array $params): void 
    {
        $this->params = $params;
    }

    public function SetPDO(PDO $pdo): void
    {
        $this->pdo = $pdo;        
    }

    public function GetContext(): array 
    {
        return [];
    }
    
    abstract public function Get();
}

