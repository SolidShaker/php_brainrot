<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"  rel="stylesheet" />
    <title>Hallway</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-meteor"></i></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/"#>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/aizen"#>Aizen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/madara"#>Madara</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
         <?php 
            $uri = $_SERVER["REQUEST_URI"];
            if ($uri == "/") 
            {
                require "../views/main.php";
            } 
            elseif (preg_match("#^/aizen#", $uri))
            {
                require "../views/aizen/aizen.php";
            } 
            elseif (preg_match("#^/madara#", $uri))
            {
                require "../views/madara/madara.php";
            } 
        ?>
    </div>
</body>

</html>
