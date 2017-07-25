<?php
    session_start();
 header('Access-Control-Allow-Origin: http://188.226.140.143', false);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once '../pages/db_connect.php';
    $sUserId = $_SESSION["userIdSession"];

//TEST TO SEE PERMISSION RULES
// $dir = '/var/www/tmp'; // create new directory with 744 permissions if it does not exist yet
 // owner will be the user/group the PHP script is run under
 // if ( !file_exists($dir) ) {
 //     $oldmask = umask(0);  // helpful when used in linux server  
 //     mkdir ($dir, 0744);
 // }
 // file_put_contents ($dir.'/test.txt', 'Hello File');



//     echo phpversion()." ";
// echo sys_get_temp_dir()." ";
echo $_FILES['image']['error']." ";
var_dump($_FILES['image']);

if($_FILES['image']['type'] != "image/png") {
    echo "Only PNG images are allowed!";
    exit;
}


$uploaddir = '../uploads/';

$uploadfile = $uploaddir . basename($_FILES['image']['name']);

if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
	$updPhoto = $con->prepare("UPDATE websecuserinfo SET image = :imageName WHERE id = :userId");
	$updPhoto->bindParam(":imageName",basename($_FILES['image']['name']));
	$updPhoto->bindParam(":userId", $sUserId);
	$updPhoto->execute();

    echo "Image succesfully uploaded.";
} else {
    echo "Image uploading failed.";
}

?> 