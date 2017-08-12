<?php
session_start();
require_once '../pages/db_connect.php';

$getToken = $_GET['token'];
if ($_SESSION["uniqueToken"] != $getToken){
	echo 'Sorry, something went wront';
}else{



$itemId = $_GET['itemId'];
$reviewer = $_SESSION["userIdSession"];
$getComment = $_GET['comment'];
$getRating = $_GET['rating'];
$user = $con->prepare("SELECT userId FROM websecrentals WHERE id LIKE :itemId;");
$user->bindParam(':itemId',$itemId);
$user->execute();
$user = $user->fetchAll();
$user = $user[0]['userId'];

if($getComment != "" && $getRating != "" && $getRating <= "5" && $getRating >= "1"){
	$result = $con->prepare("INSERT INTO websecreviews (itemId,user,reviewer,comment,rating) VALUES (:itemId,:user,:reviewer,:comment,:rating)");
	$result->bindParam(':user',$user);
	$result->bindParam(':reviewer',$reviewer);
	$result->bindParam(':comment',$getComment);
	$result->bindParam(':rating',$getRating);
	$result->bindParam(':itemId',$itemId);
	$result->execute();

	echo ("yes");
}
else
{
	echo ($getComment." ".$getRating." ");
}

}
$con = null;
?>