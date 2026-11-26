<?php



class CharacterObjectCreateController extends BaseCharacterTwigController
{
    public $template = "character_create.twig";
    public $title = "Character Create";

    public function GET(array $context)
    {
        parent::GET($context);
    }

        
    public function POST(array $context)
    {
        $title = trim($_POST["title"] ?? "");
        $descr = trim($_POST["description"] ?? "");
        $type  = trim($_POST["type"] ?? "");

        if ($title === "" || $descr === "" || $type === "")
        {
            $context["message"] = "All fields should be filled";
            return $this->GET($context);
        }

        if (!isset($_FILES["image"]) || $_FILES["image"]["error"] !== UPLOAD_ERR_OK) 
        {
            $context["message"] = "Image upload failed or no file was uploaded";
            return $this->GET($context);
        }

        // Image
        $temImage = $_FILES["image"]["tmp_name"];

        // Image Content Check
        $finfo    = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($temImage);

        $allowedMimeTypes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
        ];

        if (!array_key_exists($mimeType, $allowedMimeTypes)) 
        {
            $context["message"] = "Invalid file type. Only JPG, PNG, GIF, and WEBP images are allowed";
            return $this->GET($context);
        }

        // Image Header Check
        $imageInfo = getimagesize($temImage);

        if ($imageInfo === false) 
        {
            $context["message"] = "File does not contain valid image headers";
            return $this->GET($context);
        }

        [$width, $height] = $imageInfo;

        if ($width < 10 || $height < 10 || $width > 5000 || $height > 5000) 
        {
            $context["message"] = "Image dimensions must be between 10x10 and 5000x5000 pixels";
            return $this->GET($context);
        }

        // Prepare file paths
        $extension    = $allowedMimeTypes[$mimeType];
        $safeFilename = bin2hex(random_bytes(16)) . '.' . $extension;
        $publicUrl    = '/media/' . $safeFilename;

        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/media/';
        if (!is_dir($uploadDir)) 
            mkdir($uploadDir, 0755, true);

        $diskPath = $uploadDir . $safeFilename;

        if (!move_uploaded_file($temImage, $diskPath)) 
        {
            $context["message"] = "Failed to save the image on the server";
            return $this->GET($context);
        }

        $sql = <<<EOL
            INSERT INTO characters (title, description, type_id, image)
            SELECT :title, :description, t.id, :image_url 
            FROM characters_types t
            WHERE t.type = :type
        EOL;   

        $query = $this->pdo->prepare($sql);
        $query->bindValue(':title',       $title,     PDO::PARAM_STR);
        $query->bindValue(':description', $descr,     PDO::PARAM_STR);
        $query->bindValue(':type',        $type,      PDO::PARAM_STR);   
        $query->bindValue(':image_url',   $publicUrl, PDO::PARAM_STR);
        $query->execute();        

        if ($query->rowCount() === 0) 
        {
            @unlink($diskPath); // Clean up img file
            $context["message"] = "Invalid character type selected";
            return $this->GET($context);
        }

        $context["message"] = "Character is created";
        $context["id"] = $this->pdo->lastInsertId();

        $this->GET($context);
    }

}

