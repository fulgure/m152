<?php

function uploadImg($title) {
    $cnt = 1;
    while (checkImgExists($title)) {
        $title = substr($title, 0, -4) . '-' . $cnt . substr($title, -4);
        $cnt++;
    }
    $targetFile = 'img\\' . $title;
    $result = false;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $result = $title;
    }
    return $result;
}

function checkImgExists($title) {
    $sql = "SELECT `idPost` FROM posts WHERE `nomMedia` = :title";
    $conn = EDatabase::getInstance()->prepare($sql);
    $conn->execute(array(
        "title" => $title
    ));
    $result = $conn->fetchAll();
    return (count($result) > 0);
}

function addPost($comm, $type, $nom) {
    $sql = "INSERT INTO `posts`(`commentaire`, `typeMedia`, `nomMedia`, `datePost`) VALUES (:commentaire,:typeMedia,:nomMedia, NOW())";
    $conn = EDatabase::getInstance()->prepare($sql);
    return $conn->execute(array(
                "commentaire" => $comm,
                "typeMedia" => $type,
                "nomMedia" => $nom
    ));
}

function isImage($mime) {
    return ($mime === 'image/png' || $mime === 'image/jpeg' || $mime === 'image/gif' || $mime === 'image/bmp');
}

function getAllPosts() {
    $sql = "SELECT `commentaire`, `nomMedia`, `datePost` FROM `posts` WHERE `typeMedia` LIKE 'image/%'";
    $conn = EDatabase::getInstance()->prepare($sql);
    $conn->execute();
    $posts = $conn->fetchAll();
    $result = array();
    foreach ($posts as $post) {
        $singlePost = new EPost();
        $singlePost->commentaire = $post["commentaire"];
        $singlePost->nomImage = $post["nomMedia"];
        $singlePost->datePosted = $post["datePost"];
        array_push($result, $singlePost);
    }
    return $result;
}