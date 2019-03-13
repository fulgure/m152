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
                <?php
                foreach ($posts as $singlePost) {
                    ?>
                    <figure>
                        <?php
                        for ($i = 0; $i < count($singlePost->nomMedia); $i++) {
                            if ($singlePost->IsImage($i)) {
                                ?>
                                <img class="singleImageWrapper" src="media\\<?= $singlePost->nomMedia[$i] ?>" alt="<?= $singlePost->commentaire ?>"/>
                                <?php
                            } else if ($singlePost->IsVideo($i)) {
                                ?>
                                <video width="300" height="300" controls autoplay loop>
                                    <source src="media/<?= $singlePost->nomMedia[$i] ?>" type="<?= $singlePost->typeMedia[$i] ?>"/>
                                    Your browser does not support HTML5 video
                                </video>
                                <?php
                            } else {
                                ?>
                                <audio controls>
                                    <source src="media/<?= $singlePost->nomMedia[$i] ?>" type="<?= $singlePost->typeMedia[$i] ?>"/>
                                </audio>
                                <?php
                            }
                        }
                        ?>
                        <figcaption><?= $singlePost->commentaire ?>, Posté le <?= $singlePost->datePosted ?></figcaption>
                    </figure>
                    <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>
