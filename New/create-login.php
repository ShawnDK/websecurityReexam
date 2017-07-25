<?php
    //SET A SESSION AND GET THE FORM PARAMETERS
    session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
/**/
    $sUser = $_GET['user'];
    $sPass = $_GET['pass'];
    $sPassRepeat = $_GET['passRepeat'];
    $nameSession = $sUser;
    
    
    //GET THE DB CONNECTION DETAILS
    require_once 'db_connect.php';
    
    $queryInserted = $sUser." ".$sPass." ".$sPassRepeat;
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $queryset1 = $con->prepare("INSERT INTO queriesEntered (link,query,time)VALUES(:link,:query,CURRENT_TIMESTAMP)");
    $queryset1->bindParam(':link',$actual_link);
    $queryset1->bindParam(':query',$queryInserted);
    $queryset1->execute();

    
    //ERROR ARRAY
    $msg = array();
    
    
    //PASSWORD HASH
    $passwordHash = password_hash($sPass, PASSWORD_DEFAULT);
    
    
    //CHECK THE FORM INPUT
    if(strlen($sUser) < 8){
        $msg['user'] = 'Username has to be at least 8 characters long';
    }
    
    if(strlen($sPass) < 8){
        $msg['pass'] = 'Password has to be at least 8 characters long';
    }
    
    if(strlen($sPass) > 7 && $sPass != $sPassRepeat){
        $msg['passRepeat'] = "Passwords don't match";
    }
    
    //CHECK IF THE GIVEN USERNAME EXISTS
    $sql = $con->prepare("SELECT * FROM websecusers WHERE User=:user");
    $sql->bindParam(':user',$sUser);
    $sql->execute();

    $sql = $sql->fetchAll();

    $resultCount = count($sql);
    // $sql->store_result();
    // $sql->bind_result($result1,$result2,$result3,$result4);
    // $result = $sql->fetch();
    
    //IF THE USERNAME IS FOUND IN THE DB
    if($resultCount){
        $msg['creation'] = 'Username not available';
    }
    
    
    //CREATE USER IF EVERTHING IS OK
    //MAKE IT A LOT SIMPLER = CHECK MSG ARRAY INSTEAD!
    if(strlen($sUser) >= 8 && strlen($sPass) >= 8 && $sPass == $sPassRepeat && $resultCount == 0){
        $createSql = $con ->prepare ("INSERT INTO websecusers (User,Pass,LoggedTime) VALUES (:user,:passHash,CURRENT_TIMESTAMP)");
        $createSql->bindParam(':user',$sUser);
        $createSql->bindParam(':passHash',$passwordHash);
        $createSql ->execute();
        $msg['creationOk'] = 'Profile has successfully been created';
    }
    
    
    //IF THE ERROR ARRAY CONTAINS ANYTHING ECHO IT
    if (!empty($msg))
    {
        echo json_encode($msg);
    }

    
    //CLOSE THE CONNECTION
   // $con->close();
?>