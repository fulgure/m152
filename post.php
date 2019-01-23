<?php
include './server/includes.inc.php';
$correctInputs = 0;
if (isset($_FILES['image']['error'])) {
    if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
        if ($_FILES['image']['type'] == 'image/png' || $_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/jpeg') {
            $correctInputs++;
        } else {
            echo 'a';
        }
    } else {
        echo 'b';
    }
} else {
    echo 'c';
}
$commentaire = '';
if (isset($_REQUEST['commentaire'])) {
    $correctInputs++;
    $commentaire = filter_input(INPUT_GET, 'commentaire');
}
if ($correctInputs == 2 && strlen($commentaire) > 0) {
    $mediaName = uploadImg($_FILES['image']['name']);
    if ($mediaName !== false) {
        if (addPost($commentaire, $_FILES['type'], $nom)) {
            header('Location: index.php');
        }
    }
}
echo $correctInputs;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Poster une image</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include "server\\navbar.inc.php"
        ?>
        <div id="wrapper">
            <table>
                <form action="post.php" method="GET" enctype="multipart/form-data">
                    <tr>
                        <td>Image : </td>
                        <td><input type="file" name="image" value="" /></td>
                    </tr>
                    <tr>
                        <td>Commentaire : </td>
                        <td><textarea name="commentaire" rows="4" cols="20"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Envoyer" /></td>
                    </tr>
                </form>
            </table>
        </div>
    </body>
</html>
