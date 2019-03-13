<?php
include './server/includes.inc.php';
$correctInputs = 0;
if (isset($_FILES['media']['tmp_name'])) {
    $correctInputs++;
}
if (isset($_REQUEST['commentaire'])) {
    $correctInputs++;
    $commentaire = filter_input(INPUT_POST, 'commentaire');
}
$isOkay = false;
if ($correctInputs === 2 && strlen($commentaire) > 0) {
    $mediaName = uploadMedia($_FILES['media']['name'], $_FILES['media']['tmp_name']);
    if ($mediaName !== false) {
        $types = [];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        foreach ($mediaName as $media) {
            $mime = finfo_file($finfo,'media/'.$media);
            array_push($types, $mime);
        }
        $isOkay = addPost($commentaire, $types, $mediaName);
    }
}
if ($isOkay) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Poster média</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include "server\\navbar.inc.php"
        ?>
        <div id="wrapper">
            <div id="postWrapper">
                <h1>Poster un contenu média</h1>
                <br/>
                <hr/>
                <h2>Média(s)</h2>
                <table>
                    <form method="POST" enctype="multipart/form-data">
                        <tr>
                            <td>Image : </td>
                            <td><input type="file" name="media[]" value="" multiple  accept="image/* video/* audio/*"/></td>
                        </tr>
                        <tr>
                            <td>Commentaire : </td>
                            <td><textarea name="commentaire" rows="4" cols="80"></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="Envoyer" /></td>
                        </tr>
                    </form>
                </table>
            </div>
        </div>
    </body>
</html>
