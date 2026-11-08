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
            SELECT id, title
            FROM characters
            WHERE (:title = '' OR title ILIKE CONCAT('%', :title, '%'))
            AND (:type = '' OR type = :type)
            AND (:description = '' OR description ILIKE CONCAT('%', :description, '%')) 
        EOL;

        $query = $this->pdo->prepare($sql);

        $query->bindValue(":title", $title);
        $query->bindValue(":type", $type);
        $query->bindValue(":description", $description); 
        $query->execute();

        $context['search_characters'] = $query->fetchAll();
        
        $context['search_type'] = $type;
        $context['search_title'] = $title;
        $context['search_description'] = $description;

        return $context;
    }
}