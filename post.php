<?php
include './server/includes.inc.php';
$correctInputs = 0; 
if (isset($_FILES['image']['tmp_name'])){
    $correctInputs++;
}
if (isset($_POST['commentaire'])) {
    $correctInputs++;
    $commentaire = filter_input(INPUT_POST, 'commentaire');
}
var_dump($_FILES);
if ($correctInputs === 2 && strlen($commentaire) > 0) {
    $fileCount = count($_FILES['image']['tmp_name']);
    $mediaName = uploadImg($_FILES['image']['name']);
    if ($mediaName !== false) {
        /*if (addPost($commentaire, $_FILES['image']['type'], $mediaName)) {
            header('Location: index.php');
        }*/
    }
}
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
                <form method="POST" enctype="multipart/form-data">
                    <tr>
                        <td>Image : </td>
                        <td><input type="file" name="image[]" value="" multiple  accept="image/*"/></td>
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
