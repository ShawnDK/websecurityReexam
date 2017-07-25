<?php

    //SET A SESSION AND GET THE FORM PARAMETERS
    session_start();
    $sUser = $_GET['user'];
    $sPass = $_GET['pass'];
    $nameSession = $sUser;
    
    
    //GET THE DB CONNECTION DETAILS
    require_once 'db_connect.php';
    
    
    //ERROR ARRAY AND BAN VARIABLES
    $errors = array();
    $ban = 0;
    $siteBan = 0;
    
    $queryInserted = $sUser." ".$sPass;
    
    //GET THE USERS IP AND STORE IT IN A VARIABLE
    $ip = $_SERVER["REMOTE_ADDR"];

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $queryset1 = $con->prepare("INSERT INTO queriesEntered (link,query,time)VALUES(?,?,CURRENT_TIMESTAMP)");
    $queryset1->bind_param('ss',$actual_link, $queryInserted);
    $queryset1->execute();
    
    //LOG THE IP ADDRESS AND THE USERNAME TRIED TO ACCESS THE SYSTEM WITH
    $queryset = $con->prepare("INSERT INTO websecip (address,username,timestamp)VALUES(?,?,CURRENT_TIMESTAMP)");
    $queryset->bind_param('ss', $ip, $sUser);
    $queryset->execute();
    
    

    
    //CHECK FOR SITE BAN BY USING THE SITELOCK DB FIELD COMPARED TO THE CURRENT USER IP WITHIN THE LAST 20 MIN
    $siteBanSql = $con->prepare("SELECT * FROM websecip WHERE sitelock LIKE ? AND timestamp > (now() - interval 20 minute)");
    $siteBanSql->bind_param('s', $ip);
    $siteBanSql->execute();
    $siteBanSql->store_result();
    $siteBanSql->bind_result($resultIp,$lockIp,$siteLock,$triedUsername, $resultTime);
    $siteLockoutCheckResult = $siteBanSql->fetch();
    $siteLockoutCheckCount = $siteBanSql->num_rows;
    
    //IF A RESULT IS FOUND THEN ASSIGN 1 TO THE SITEBAN VARIABLE FOR USE FURTHER DOWN THIS CODE
    if($siteLockoutCheckCount == 1){
        $errors['attempts'] = 'Your ip is currently banned';
        $siteBan = 1;
    }

    
    //CHECK IF THE IP ADDRESS EXISTS WITHIN THE LOCKOUT DB FIELD WITHIN THE LAST 5 MIN
    $ipLockoutCheck = $con->prepare("SELECT * FROM websecip WHERE lockout LIKE ? AND username = ? AND timestamp > (now() - interval 5 minute)");
    $ipLockoutCheck->bind_param('ss', $ip, $sUser);
    $ipLockoutCheck->execute();
    $ipLockoutCheck->store_result();
    $ipLockoutCheck->bind_result($resultIp,$lockIp,$siteLock,$triedUsername, $resultTime);
    $ipLockoutCheckResult = $ipLockoutCheck->fetch();
    $ipLockoutCheckCount = $ipLockoutCheck->num_rows;
    //IF THE IP EXISTS THEN ASSIGN 1 TO THE BAN VARIABLE FOR USE FURTHER DOWN THIS CODE
       if(!empty($lockIp) && $triedUsername == $sUser && $siteBan == 0){
        $errors['attempts'] = 'User currently locked from this ip';
        $ban = 1;
    }
    
    
    //SUCCESSFUL LOGIN
    $sql = $con->prepare("SELECT * FROM websecusers WHERE User=?");
    $sql->bind_param('s', $sUser);
    $sql->execute();
    $sql->store_result();
    $sql->bind_result($result1,$result2,$result3,$result4);
    $result = $sql->fetch();
    
    //SET THE CURRENT TIME AS A VARIABLE
    /*$currentTime = new DateTime(date('Y-m-d H:i:s'));
    $databaseTime = new DateTime($result4);
    $difference = $databaseTime->diff($currentTime);*/
    

    if($result==1 && password_verify($sPass, $result3) && $ban == 0 && $siteBan == 0){
        echo 'loginpass';
        $_SESSION['userSession'] = $nameSession;
        //echo $_SESSION['nameInput'];
        $query = $con->prepare("UPDATE websecusers SET LoggedTime=NOW() WHERE User=?");
        $query->bind_param('s', $sUser);
        $query->execute();
        
        //DELETE IP RECORDS FOR SPECIFIC IP ON SUCCESSFULL LOGIN TO KEEP THE TABLE SOMEWHAT TIDY
        $query = $con->prepare("DELETE FROM websecip WHERE address=?");
        $query->bind_param('s', $ip);
        $query->execute();
    }
    
    
    //CHECK FOR ATTEMPTS WITHIN 5 MIN
    $ipCheck = $con->prepare("SELECT * FROM websecip WHERE address LIKE ? AND username = ? AND timestamp > (now() - interval 5 minute)");
    $ipCheck->bind_param('ss', $ip, $sUser);
    $ipCheck->execute();
    $ipCheck->store_result();
    $ipCheck->bind_result($resultIp,$lockIp,$siteLock,$loggedUsername,$resultTime);
    $ipCheckResult = $ipCheck->fetch();
    $ipCheckCount = $ipCheck->num_rows;
    
    //IF THE NUMBER OF ROWS RETURNED FROM THE SQL EQUALS A SPECIFIC NUMBER AND THE IP IS NOT BANNED
    if($ipCheckCount == 1 && $loggedUsername == $sUser && $ban == 0 && $siteBan == 0){
        $errors['attempts'] = 'Incorrect login. <br>Your are allowed 4 more attempts within 10 minutes';
    } elseif ($ipCheckCount > 1 && $ipCheckCount < 5 && $loggedUsername == $sUser && $ban == 0 && $siteBan == 0){
        $errors['attempts'] = 'Incorrect login';
    } elseif ($ipCheckCount == 5 && $loggedUsername == $sUser && $ban == 0 && $siteBan == 0){
        //BAN IP IF THE NUMBER OF TRIES (ROWS RETURNED FROM THE SQL) IS 5
        $errors['attempts'] = 'Your are now banned for 5 minutes';
        $lookSet = $con->prepare("INSERT INTO websecip (address,lockout,username,timestamp)VALUES(?,?,?,CURRENT_TIMESTAMP)");
        $lookSet->bind_param('sss',$ip,$ip,$sUser);
        $lookSet->execute();
    }
    
    
    //IF IP TRIES 10 DIFFERENT USERNAMES WITHIN 5 MIN BAN COMPLETELY FOR 20 MIN (20 MIN BAN IS DEFINED FURTHER UP IN THIS DOCUMENT)
    $distinctCheck = $con->prepare("SELECT DISTINCT username FROM websecip WHERE address LIKE ? AND timestamp > (now() - interval 5 minute)");
    $distinctCheck->bind_param('s', $ip);
    $distinctCheck->execute();
    $distinctCheck->store_result();
    $distinctCheck->bind_result($loggedUsername);
    $distinctCheckResult = $distinctCheck->fetch();
    $distinctCheckCount = $distinctCheck->num_rows;
    
    //IF THERE IS FOUND 10 DIFFERENT (DISTINCT) USERNAME TRIES FROM THE SAME IP
    if($distinctCheckCount == 10 && $ban == 0 && $siteBan == 0){
        $errors['attempts'] = 'You tried to many different usernames. Your temporarily banned';
        //BAN IP
        $lookSet = $con->prepare("INSERT INTO websecip (address,lockout,sitelock,username,timestamp)VALUES(?,?,?,?,CURRENT_TIMESTAMP)");
        $lookSet->bind_param('ssss',$ip,$ip,$ip,$sUser);
        $lookSet->execute();
    }
    
    
    //IF THE ERROR ARRAY CONTAINS ANYTHING ECHO IT
    if (!empty($errors))
    {
        echo json_encode($errors);
    }
    
    
    //CLOSE THE CONNECTION
    $con->close();
?>