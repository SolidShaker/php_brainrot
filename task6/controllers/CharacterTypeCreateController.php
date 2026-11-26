<?php



class CharacterTypeCreateController extends BaseCharacterTwigController
{
    public $template = "type_create.twig";
    public $title = "Type Creation";

    public function GET(array $context)
    {
        parent::GET($context);
    }

        
    public function POST(array $context)
    {
        $type = trim($_POST["type"] ?? "");

        if ($type === "")
        {
            $context["message"] = "Type should be filled";
            return $this->GET($context);
        }

        $sql = <<<EOL
            INSERT INTO characters_types (type)
            VALUES (:type)
            ON CONFLICT (type) DO NOTHING
        EOL;   

        $query = $this->pdo->prepare($sql);
        $query->bindValue(':type', $type);
        $query->execute();        

        if ($query->rowCount() === 0) 
        {
            $context["message"] = "Character type '$type' already exists";
            return $this->GET($context);
        }
                        
        $context["message"] = "Type '$type' was created";

        $this->GET($context);
    }

}

