<?php
require 'php/sessionManager.php';
require 'DAL/PhotosCloudDB.php';

userAccess();
if (!isset($_GET["photoId"])) 
    redirect("photosList.php");

$photoId = (int)$_GET["photoId"];
$userId = (int)$_SESSION["currentUserId"];
// todo
//Maximum de 10 likes par photo
$userLikeCount = count(LikesTable()->selectWhere("UserId = $userId AND PhotoId = $photoId"));

if ($userLikeCount < 10) {
$userId = (int)$_SESSION["currentUserId"];
$userLike = count(LikesTable()->selectWhere("UserId = $userId AND PhotoId = $photoId")) > 0;
$photo = PhotosTable()->get($photoId);
if($userLike == true){
    $photo->setLikes($photo->Likes - 1);
    $like = LikesTable()->selectWhere("UserId = $userId AND PhotoId = $photoId");
    $likeId = $like[0]->Id;
    LikesTable()->delete($likeId);
}
else{
    $photo->setLikes($photo->Likes + 1);
    $Like = new like();
    $Like->setUserId($userId);
    $Like->setPhotoId($photoId);
    LikesTable()->insert($Like);
}
PhotosTable()->update($photo);
}

redirect("photoDetails.php?id=$photoId");