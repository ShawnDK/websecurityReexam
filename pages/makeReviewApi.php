<?php

require_once 'db_connect.php';
$user = "0001";
$reviewer = "0666";

$getComment = $_GET['comment'];
$getRating = $_GET['rating'];

if($getComment != "" && $getRating != "" && $getRating <= "5" && $getRating >= "1"){
$result = $con->prepare("INSERT INTO websecreviews (user,reviewer,comment,rating) VALUES (:user,:reviewer,:comment,:rating)");
$result->bindParam(':user',$user);
$result->bindParam(':reviewer',$reviewer);
$result->bindParam(':comment',$getComment);
$result->bindParam(':rating',$getRating);
$result->execute();

echo ("yes");
}
            else
{
            echo ("no");
}


$con = null;

?>