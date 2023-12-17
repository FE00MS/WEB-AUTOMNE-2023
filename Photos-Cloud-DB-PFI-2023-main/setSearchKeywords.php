<?php
require 'php/sessionManager.php';
require 'DAL/PhotosCloudDB.php';
//sert à nettoyer les mots
if(!isset($_GET["keywords"]))
    redirect("photosList.php");

$keywords = $_GET["keywords"];

//si tapé 'é' tous les mots seront ceux avec 'e'
//$keywords = iconv('UTF-8', 'ASCII//TRANSLIT', $keywords);

redirect("photosList.php?keywords=$keywords");