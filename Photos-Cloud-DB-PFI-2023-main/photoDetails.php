<?php
include 'php/sessionManager.php';
include 'php/date.php';
require 'DAL/PhotosCloudDB.php';
$viewTitle = "Détails de photo";

userAccess();

if (!isset($_GET["id"]))
    redirect("illegalAction.php");

$id = (int) $_GET["id"];

$photo = PhotosTable()->get($id);
if ($photo == null)
    redirect("illegalAction.php");
$userId = (int)$_SESSION["currentUserId"];

$title = $photo->Title;
$description = $photo->Description;
$image = $photo->Image;
$likes = $photo->Likes;


$userLike = count(LikesTable()->selectWhere("UserId = $userId AND PhotoId = $id")) > 0;
$photoLikedByConnectedUser = $userLike ? "fa" : "fa-regular"; 

$likesUsersList = ""; // todo
$userList = LikesTable()->selectWhere("PhotoId = $id");
foreach ($userList as $like) {
    $user = UsersTable()->get($like->UserId);
    $likesUsersList .= $user->Name. "\n";
}



$owner = UsersTable()->Get($photo->OwnerId);
$ownerName = $owner->Name;
$ownerAvatar = $owner->Avatar;
$shared = $photo->Shared == "true";
$creationDate = timeStampToFullDate(strtotime($photo->CreationDate));

//Like changes
$LikesLink = "";
if($userLike == true){
$LikesLink = <<<HTML
    <div class="likesSummary">
        $likes
        <a href="togglePhotoLike.php?photoId=$id" class="cmdIconSmall $photoLikedByConnectedUser fa fa-thumbs-up" id="addRemoveLikeCmd" title="$likesUsersList" ></a> 
    </div>
HTML;
}
else{
  $LikesLink = <<<HTML
    <div class="likesSummary">
        $likes
        <a href="togglePhotoLike.php?photoId=$id" class="cmdIconSmall $photoLikedByConnectedUser fa-thumbs-up" id="addRemoveLikeCmd" title="$likesUsersList" ></a> 
    </div>
HTML;  
}


$viewContent = <<<HTML
    <div class="content">
        <div class="photoDetailsOwner">
        <div class="UserAvatarSmall" style="background-image:url('$ownerAvatar')" title="$ownerName"></div>
        $ownerName
        </div>
        <hr>
        <div class="photoDetailsTitle">$title</div>
        <img src="$image" class="photoDetailsLargeImage">
        <div class="photoDetailsCreationDate">
        $creationDate
        $LikesLink
        <div class="photoDetailsDescription">$description</div>
    HTML;
$viewScript = <<<HTML
        <script defer>
            $("#addPhotoCmd").hide();
        </script>
    HTML;
include "views/master.php";