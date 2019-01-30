<?php
include './server/includes.inc.php';
$posts = getAllPosts();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include "server\\navbar.inc.php";
        ?>
        <div id="wrapper">
            <div id="indexWrapper">
                <img src="img\\avatar.jpg" alt="Image de profil" id="profilePicture"/>
                <h1>Bienvenue !</h1>
                <hr>
                <?php foreach ($posts as $singlePost) { ?>
                    <figure>
                        <img class="singleImageWrapper" src="img\\<?= $singlePost->nomImage ?>" alt="<?= $singlePost->commentaire ?>"/>
                        <figcaption><?= $singlePost->commentaire ?>, Posté le <?= $singlePost->datePosted ?></figcaption>
                    </figure>
                <?php } ?>
            </div>
        </div>
    </body>
</html>
