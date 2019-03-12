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
                    if (!is_array($singlePost->nomMedia)) {
                        ?>
                        <figure>
                            <?php
                            if ($singlePost->hasImage) {
                                ?>
                                <img class="singleImageWrapper" src="media\\<?= $singlePost->nomMedia[0] ?>" alt="<?= $singlePost->commentaire ?>"/>
                                <?php
                            } else {
                                ?>
                                <video width="300" height="300" controls>
                                    <source src="<?= $singlePost->nomMedia ?> type='<?= $singlePost->typeMedia ?>'"/>
                                    Your browser does not support HTML5 video
                                </video>
                                <?php
                            }
                            ?>
                            <figcaption><?= $singlePost->commentaire ?>, Posté le <?= $singlePost->datePosted ?></figcaption>
                        </figure>
                        <?php
                    } else {
                        ?>
                        <figure>
                            <?php
                            foreach ($singlePost->nomMedia as $media) {
                                if ($singlePost->hasImages) {
                                    ?>
                                    <img class="singleImageWrapper" src="media\\<?= $media ?>" alt="<?= $singlePost->commentaire ?>"/>
                                    <?php
                                } else {
                                    ?>
                                    <video width="300" height="300" controls>
                                        <source src="<?= $media ?> type='<?= $singlePost->typeMedia ?>'"/>
                                        Your browser does not support HTML5 video
                                    </video>
                                    <?php
                                }
                            }
                            ?>
                            <figcaption><?= $singlePost->commentaire ?>, Posté le <?= $singlePost->datePosted ?></figcaption>
                        </figure>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>
