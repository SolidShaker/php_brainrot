<?php




class CharacterObjectUpdateController extends BaseCharacterTwigController
{
    public $template = "character_update.twig";
    public $title = "Character Update";

    public function GET(array $context)
    {
        $id = $this->params['id'];

        $sql = <<<SQL
            SELECT
                c.id,
                c.title,
                c.description,
                c.image,
                c.type_id,
                t.type
            FROM characters c
            JOIN characters_types t ON t.id = c.type_id
            WHERE c.id = :id
        SQL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        if (!$data)
        {
            $context["message"] = "Character not found. It may have been deleted.";
            $context["show_form"] = false;
            return parent::GET($context);
        }

        $context['character_by_id'] = $data;
        $context["show_form"] = true;

        parent::GET($context);
    }

    public function POST(array $context)
    {
        $id = $this->params['id'];

        $title = trim($_POST["title"] ?? "");
        $descr = trim($_POST["description"] ?? "");
        $type  = trim($_POST["type"] ?? "");

        if ($title === "" || $descr === "" || $type === "") 
        {
            $context["message"] = "All fields should be filled";
            return $this->GET($context);
        }

        $sql = "SELECT * FROM characters WHERE id = :id";

        $query = $this->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();

        $character = $query->fetch(PDO::FETCH_ASSOC);
        if (!$character) // We don't want a user to submit data to non-existend character
        {
            $context["message"] = "Character not found. It may have been deleted.";
            return parent::GET($context);
        }

        $publicUrl = $character['image'];
        if ($_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE)  // Checking if file was uploaded
        {

            // Checking if error occurred during an upload
            if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) 
            {
                $context["message"] = "Image upload failed";
                return $this->GET($context);
            }

            // Checking contents of the file instead of trusting a given type
            $tempImage = $_FILES["image"]["tmp_name"];

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($tempImage);

            $allowedMimeTypes = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/gif'  => 'gif',
                'image/webp' => 'webp',
            ];

            if (!array_key_exists($mimeType, $allowedMimeTypes)) 
            {
                $context["message"] = "Invalid image type";
                return $this->GET($context);
            }

            // Check of the image headers 
            $imageInfo = getimagesize($tempImage);

            if ($imageInfo === false) 
            {
                $context["message"] = "Invalid image file";
                return $this->GET($context);
            }

            
            // Restricting to certain size of the image
            [$width, $height] = $imageInfo;

            if (
                $width < 10 || $height < 10 ||
                $width > 5000 || $height > 5000
            ) {
                $context["message"] = "Image dimensions must be between 10x10 and 5000x5000 pixels";
                return $this->GET($context);
            }

            $extension = $allowedMimeTypes[$mimeType]; 
            $safeFilename = bin2hex(random_bytes(16)) . '.' . $extension; // Encoding into unique name
            $publicUrl = '/media/' . $safeFilename; 

            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/media/';

            $diskPath = $uploadDir . $safeFilename;

            if (!move_uploaded_file($tempImage, $diskPath)) 
            {
                $context["message"] = "Failed to save image";
                return $this->GET($context);
            }
        }

        // Updating character
        $sql = <<<SQL
            UPDATE characters
            SET title = :title,
                description = :description,
                type_id = (
                    SELECT id FROM characters_types WHERE type = :type
                ),
                image = :image
            WHERE id = :id
        SQL;

        $query = $this->pdo->prepare($sql);

        $query->bindValue(":title", $title);
        $query->bindValue(":description", $descr);
        $query->bindValue(":type", $type);
        $query->bindValue(":image", $publicUrl);
        $query->bindValue(":id", $id);

        $query->execute();

        $context["message"] = "Character updated successfully!";
        $context["id"] = $id;

        $this->GET($context);
    }
}

