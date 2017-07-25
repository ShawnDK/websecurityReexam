<?php
    //SET A SESSION AND GET THE FORM PARAMETERS
    session_start();
    require_once '../pages/db_connect.php';
    
    $sTitle = $_POST['name'];
    $sDes = $_POST['description'];
    $sPrice = $_POST['price'];
    $sPeriod = $_POST['period'];
    $sUserId = $_SESSION["userIdSession"];

    $addprod = $con->prepare("INSERT INTO websecrentals (userId,title,des,price,image,rentPeriod) VALUES (:userId,:title,:des,:price,:image,:period)");
    $addprod->bindParam(':userId', $sUserId);
    $addprod->bindParam(':title', $sTitle);
    $addprod->bindParam(':des', $sDes);
    $addprod->bindParam(':price', $sPrice);
    $addprod->bindParam(':period', $sPeriod);
    
    $referenceVariable = '';

    $uploaddir = '../uploads/';
    $uploadfile = $uploaddir . basename($_FILES['file_img']['name']);
    if (move_uploaded_file($_FILES['file_img']['tmp_name'], $uploadfile)) {
        echo "Image succesfully uploaded.";
        $addprod->bindParam(':image', basename($_FILES['file_img']['name']));  
    } else {
        echo "Image uploading failed.";
        $addprod->bindParam(':image', $referenceVariable);
    }
  
    $addprod->execute();
    
    $uploaddir = '../uploads/';

    $uploadfile = $uploaddir . basename($_FILES['file_img']['name']);

 



?>