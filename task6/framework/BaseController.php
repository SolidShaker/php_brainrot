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

    public function ProcessResponse(): void
    {
        $method = $_SERVER["REQUEST_METHOD"];
        if ($method == "GET")
        {
            $this->GET($this->GetContext());
        } 
        else if ($method == "POST") 
        {
            $this->POST($this->GetContext());
        }
    }

    public function GET(array $context) {}
    public function POST(array $context) {}
}

