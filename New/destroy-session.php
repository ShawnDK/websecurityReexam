<?php
    session_start();
    $nameSession = $_SESSION['userSession'];

   /* 
    $query = $con->prepare("UPDATE websecusers SET LoggedIn=0 WHERE User=?");
    $query->bind_param('s', $nameSession);
    $query->execute();
    $query->store_result();
    
    $con->close();    */
    
    session_unset();
    session_destroy();
    echo "destroy";
?>