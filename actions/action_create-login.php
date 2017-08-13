<?php
    //SET A SESSION AND GET THE FORM PARAMETERS
    //session_start();
    $sUser = $_GET['user'];
    $sEmail = $_GET['email'];
    $sPass = $_GET['pass'];
    $sPassRepeat = $_GET['passRepeat'];
    $nameSession = $sUser;
    
    //GET THE DB CONNECTION DETAILS
    require_once '../pages/db_connect.php';
    
    
    //ERROR ARRAY
    $msg = array();
    
    
    //PASSWORD HASH
    $passwordHash = password_hash($sPass, PASSWORD_DEFAULT);
    
    
    //CHECK THE FORM INPUT
    if(strlen($sUser) < 8){
        $msg['user'] = 'Username has to be at least 8 characters long';
    }
    
    if(!filter_var($sEmail, FILTER_VALIDATE_EMAIL) === false){
        //$msg['email'] = 'Thats not a valid email';
    }else{
        $msg['email'] = 'Thats not a valid email';
    }
    
    if(strlen($sPass) < 8){
        $msg['pass'] = 'Password has to be at least 8 characters long';
    }
    
    if(strlen($sPass) > 7 && $sPass != $sPassRepeat){
        $msg['passRepeat'] = "Passwords don't match";
    }
    
    
    //CHECK IF THE GIVEN USERNAME EXISTS
    $sql = $con->prepare("SELECT * FROM websecusers WHERE User=:sUser");
    $sql->bindParam(':sUser', $sUser);
    $sql->execute();
    $result = $sql->fetchAll();
    $resultC = $sql->rowCount();
    
    //IF THE USERNAME IS FOUND IN THE DB
    if($resultC == 1){
        $msg['creation'] = 'Username not available';
    }
    
    
    //CREATE USER IF EVERTHING IS OK
    //MAKE IT A LOT SIMPLER = CHECK MSG ARRAY INSTEAD!
    if(strlen($sUser) >= 8 && strlen($sPass) >= 8 && $sPass == $sPassRepeat && $result == false){
        $createSql = $con ->prepare ("INSERT INTO websecusers (user,email,pass,loggedTime) VALUES (:sUser,:sEmail,:Pass,CURRENT_TIMESTAMP)");
        $createSql ->bindParam(':sUser', $sUser);
        $createSql ->bindParam(':sEmail', $sEmail);
        $createSql ->bindParam(':Pass', $passwordHash);
        $createSql ->execute();
        
        
        $sAdressVariable = 'No adress';
        
        $createSql2 = $con ->prepare ("INSERT INTO websecuserinfo (userId,adress) VALUES ((SELECT id FROM websecusers WHERE user=:uName),:sAdress)");
        $createSql2 ->bindParam(':uName', $sUser);
        $createSql2 ->bindParam(':sAdress', $sAdressVariable);
        $createSql2 ->execute();
        
        
        $msg['creationOk'] = 'Profile has successfully been created';
    }
    
    
    //IF THE ERROR ARRAY CONTAINS ANYTHING ECHO IT
    if (!empty($msg))
    {
        echo json_encode($msg);
    }
    
    
    //CLOSE THE CONNECTION
    $con = null;
?>