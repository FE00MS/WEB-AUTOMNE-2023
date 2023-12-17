<?php
require 'php/sessionManager.php';
require 'DAL/PhotosCloudDB.php';
//sert à nettoyer les mots
if(!isset($_GET["id"]))
    redirect("photosList.php");

$ID = $_GET["id"];

redirect("photosList.php?id=$ID");