<?php
    //SET A SESSION AND GET THE FORM PARAMETERS
    session_start();

    if(!isset($_SESSION['userSession']))
    {
        header("location: index.php");
    }
    
// if ("POST" == $_SERVER["REQUEST_METHOD"]) {
//     if (isset($_SERVER["HTTP_ORIGIN"])) {
//         $address = "http://".$_SERVER["SERVER_NAME"];
//         if (strpos($address, $_SERVER["HTTP_ORIGIN"]) !== 0) {
//             exit("CSRF protection in POST request: detected invalid Origin header: ".$_SERVER["HTTP_ORIGIN"]);
//         }
//     }
// }
    $sComment = $_GET['c'];
    
    //GET THE DB CONNECTION DETAILS
    require_once 'db_connect.php';
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $queryset1 = $con->prepare("INSERT INTO queriesEntered (link,query,time)VALUES(?,?,CURRENT_TIMESTAMP)");
    $queryset1->bind_param('ss',$actual_link, $sComment);
    $queryset1->execute();


    if(strlen($sComment) > 100){
        echo 'w';
    }else{
        $postComment = $con ->prepare ("INSERT INTO websecMandatoryComments (comment) VALUES (?)");
        $postComment ->bind_param("s",$sComment);
        $postComment ->execute();
    }
       
    $con->close();
?>