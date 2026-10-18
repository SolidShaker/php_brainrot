<?php
$is_image = $uri == '/aizen/image';
$is_info  = $uri == '/aizen/info';
?>


<h1>Aizen<h1/>
<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-link <?= $is_image ? "active" : "" ?>" href="/aizen/image">
            Picture
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $is_info ? "active" : "" ?>" href="/aizen/info">
            Info
        </a>
    </li>
</ul>




<ul class="list-group">
    <li class="list-group-item">
        <?php
            if ($is_image)
            {
                require "aizen_image.php";
            }
            elseif ($is_info)
            {
                require "aizen_info.php";
            }
            else
            {
                echo "Please choose a category";
            }
        ?>
    </li>
</ul>
