<?php

class CharacterObjectDeleteController extends BaseController 
{
    public function POST(array $context)
    {
        $id = $this->params["id"]; 

        $sql =<<<EOL
            DELETE FROM characters WHERE id = :id
        EOL; 
        
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();

        header("Location: /");
        exit; 
    }
}
