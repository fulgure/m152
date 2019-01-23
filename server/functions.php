<?php
function uploadImg($title) {
    $targetFile = 'img\\' . $title;
    $cnt = 1;
    while (checkImgExists($title)) {
        $targetFile = substr($targetFile, 0, -4) . $cnt . substr($targetFile, -4);
        $cnt++;
    }
    $result = false;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $result = substr($targetFile, 4);
    }
    return $result;
}

function checkImgExists($title) {
    $sql = "SELECT `idPost` FROM posts WHERE `nomMedia` = :title";
    $conn = EDatabase::getInstance();
    $result = $conn->execute(array(
        "title" => $title
    ));
    $result = $result->fetchAll();
    return (count($result) > 0);
}

function addPost($comm, $type, $nom) {
    $sql = "INSERT INTO `posts`(`commentaire`, `typeMedia`, `nomMedia`, `datePost`) VALUES (:commentaire,:typeMedia,:nomMedia, NOW())";
    $conn = EDatabase::getInstance();
    return $conn->execute(array(
                "commentaire" => $comm,
                "typeMedia" => $type,
                "nomMedia" => $nom
    ));
}
