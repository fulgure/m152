<?php

function uploadMedia($titles, $tmpNames) {
    if (is_array($titles)) {
        $result = [];
        for ($i = 0; $i < count($titles); $i++) {
            if (!uploadSingleMedia($titles[$i], $tmpNames[$i])) {
                return false;
            }
            array_push($result, $titles[$i]);
        }
    } else {
        if (!uploadSingleMedia($titles, $tmpNames)) {
            return false;
        } else {
            $result = $titles;
        }
    }
    return $result;
}

function uploadSingleMedia($title, $tmpName) {
    $cnt = 1;
    while (checkMediaExists($title)) {
        $title = substr($title, 0, -4) . '-' . $cnt . substr($title, -4);
        echo $title;
        $cnt++;
    }
    $targetFile = 'media\\' . $title;
    $result = false;
    if (move_uploaded_file($tmpName, $targetFile)) {
        $result = $title;
    }
    return $result;
}

function checkMediaExists($title) {
    $sql = "SELECT `idPost` FROM media WHERE `nomFichierMedia` = :title";
    $conn = EDatabase::prepare($sql);
    $conn->execute(array(
        "title" => $title
    ));
    $result = $conn->fetchAll();
    return (count($result) > 0);
}

function addMediaToDB($noms, $type, $postID) {
    $result = true;
    if (is_array($noms)) {
        $cpt = 0;
        foreach ($noms as $nom) {
            $result = $result && addSingleMediaToDB($nom, $type[$cpt], $postID);
            $cpt++;
        }
    } else {
        $result = addSingleMediaToDB($noms, $type, $postIDs);
    }
    return $result;
}

function addSingleMediaToDB($nom, $type, $lastId) {
    $sql = "INSERT INTO `media`(`nomFichierMedia`, `typeMedia`, `idPost`) VALUES (:nom, :type, :id)";
    $conn = EDatabase::prepare($sql);
    $result = $conn->execute(array(
        'nom' => $nom,
        'type' => $type,
        'id' => $lastId
    ));
    return $result;
}

function addPost($comm, $type, $nom) {
    $sql = "INSERT INTO `posts`(`commentaire`, `datePost`) VALUES (:commentaire,NOW())";
    $conn = EDatabase::getInstance();
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        "commentaire" => $comm,
    ));
    if (!$result) {
        return false;
    }
    $lastId = $conn->lastInsertId();
    return addMediaToDB($nom, $type, $lastId);
}



function getAllPosts() {
    $sql = "SELECT idPost, commentaire, datePost FROM posts";
    $conn = EDatabase::getInstance();
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $posts = $stmt->fetchAll();
    $result = [];
    foreach ($posts as $post) {
        $singlePost = new EPost();
        $singlePost->commentaire = $post["commentaire"];
        $singlePost->hasImages = postContainsImages($post['idPost']);
        $singlePost->nomMedia = getMediaFromPost($post['idPost']);
        $singlePost->datePosted = $post["datePost"];
        $singlePost->typeMedia = post[""]
        array_push($result, $singlePost);
    }
    return $result;
}

function postContainsImages($id){
    $sql = "SELECT COUNT(m.idMedia) AS cnt FROM `media` AS m JOIN posts AS p ON p.idPost = m.idPost WHERE m.typeMedia LIKE 'image/%' and m.idPost = :id";
    $stmt = EDatabase::prepare($sql);
    $stmt->execute(array(
        'id' => $id
    ));
    $result = $stmt->fetchAll();
    return ($result[0]["cnt"] > 0);
}
function getMediaFromPost($idPost) {
    $sql = "SELECT m.nomFichierMedia, m.typeMedia from Media as m JOIN posts as p ON m.idPost = p.idPost WHERE m.idPost = :id";
    $conn = EDatabase::getInstance()->prepare($sql);
    $conn->execute(array(
        'id' => $idPost
    ));
    $images = $conn->fetchAll();
    $result = [];
    ///TODO
    foreach ($images as $image) {
        array_push($result, $image["nomFichierMedia"]);
    }
    return $result;
}
