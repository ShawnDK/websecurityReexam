<?php
    //SET A SESSION AND GET THE FORM PARAMETERS
    session_start();
    require_once '../pages/db_connect.php';
    $sUserId = $_SESSION["userIdSession"];
    
    if(isset($_GET['pass']) && isset($_GET['usr'])) {
        $sUsername = $_GET['usr'];
        $sPassword = password_hash($_GET['pass'], PASSWORD_DEFAULT);
        $updateUser = $con->prepare("UPDATE websecusers SET user = :username, pass = :newPass WHERE id=:userId");
        $updateUser->bindParam(":username", $sUsername);
        $updateUser->bindParam(":newPass", $sPassword);
        $updateUser->bindParam(":userId", $sUserId);
        $updateUser->execute();
    }else{
        $sAdress = $_GET['adress'];
        $sLastName = $_GET['lastname'];
        $sFirstName = $_GET['firstname'];
        $iAge = (int)$_GET['age'];

        $updateUser = $con->prepare("UPDATE websecuserinfo SET firstname = :firstName, lastname = :lastName, age=:age, adress=:adress WHERE id=:userId");
        $updateUser->bindParam(':userId', $sUserId);

        $updateUser->bindParam(':adress', $sAdress);
        $updateUser->bindParam(':age', $iAge);
        $updateUser->bindParam(':lastName', $sLastName);
        $updateUser->bindParam(':firstName', $sFirstName);
        $updateUser->execute();
    }
    
    echo 'yes';

?>