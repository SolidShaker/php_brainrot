<?php



class SearchController extends BaseCharacterTwigController
{
    public $template = "search.twig";

    public function GetContext(): array
    {
        $context = parent::GetContext();

        $type        = $_GET['search_type'] ?? '';
        $title       = $_GET['search_title'] ?? '';
        $description = $_GET['search_description'] ?? ''; 

        $sql = <<< EOL
            SELECT c.id, c.title
            FROM characters c
            JOIN characters_types t ON t.id = c.type_id
            WHERE (:title = '' OR c.title ILIKE CONCAT('%', :title, '%'))
            AND (:type = '' OR t.type = :type)
            AND (:description = '' OR c.description ILIKE CONCAT('%', :description, '%')) 
        EOL;

        $query = $this->pdo->prepare($sql);

        $query->bindValue(":title",         $title);
        $query->bindValue(":type",          $type);
        $query->bindValue(":description",   $description); 
        $query->execute();

        $context['search_characters'] = $query->fetchAll();
        
        $context['search_type'] = $type;
        $context['search_title'] = $title;
        $context['search_description'] = $description;

        return $context;
    }
}

