<?php
//HIDE EVENTUAL SERVER ERRORS
/*error_reporting(0);*/

//CONNECTION TO THE SERVER
/*
$con = new mysqli('shawndesign.dk.mysql','shawndesign_dk','WVAdn5Vb','shawndesign_dk');
*/
//shell_exec("ssh -fNg -L 3307:Group05:3306 user@remote_host");
// $con = new mysqli('127.0.0.1','root','rotdaucuscarrot','sys');
    
$con = new PDO('mysql:host=127.0.0.1;dbname=sys','root','rotdaucuscarrot');
//IF THERE IS ANY ERRORS DISPLAY IT (UNLESS ERROR_REPORTING IS SET ^^)
/*
if ($con->connect_error){
    $error = $con->connect_error;
}
*/
// Check connection
// if ($con->connect_error) {
//     die("Connection failed: " . $con->connect_error);
// } 
