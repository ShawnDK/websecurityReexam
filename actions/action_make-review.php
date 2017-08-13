<?php
session_start();
require_once '../pages/db_connect.php';

$getToken = $_GET['token'];
if (empty($_SESSION["uniqueToken"]) || $_SESSION["uniqueToken"] != $getToken){
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

//TEST
$user2 = $con->prepare("SELECT * FROM websecreviews WHERE reviewer LIKE :userId AND itemId LIKE :itemId AND reviewTime > (now() - interval 2 minute)");
$user2->bindParam(':userId',$reviewer);
$user2->bindParam(':itemId',$itemId);
$user2->execute();
//$user2 = $user2->fetchAll();
$count = $user2->rowCount();

//echo $count;
if($count != 0)
{
	echo 'no';
}



//TEST END

if($count == 0 && $getComment != "" && $getRating != "" && $getRating <= "5" && $getRating >= "1"){
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
	//echo ($getComment." ".$getRating." ");
}

}
$con = null;
unset($_SESSION["uniqueToken"]);

?>