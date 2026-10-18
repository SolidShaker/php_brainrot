<?php
$is_image = $uri == '/madara/image';
$is_info  = $uri == '/madara/info';
?>


<h1>Madara<h1/>
<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-link <?= $is_image ? "active" : "" ?>" href="/madara/image">
            Picture
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $is_info ? "active" : "" ?>" href="/madara/info">
            Info
        </a>
    </li>
</ul>

<ul class="list-group">
    <li class="list-group-item">
        <?php
            if ($is_image)
            {
                require "madara_image.php";
            }
            elseif ($is_info)
            {
                require "madara_info.php";
            }
            else
            {
                echo "Please choose a category";
            }
        ?>
    </li>
</ul>

