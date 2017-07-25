<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	session_start();
	include 'classes/simpleUrl.php';
	$aUrl = new simpleUrl;

	/*BUILDING THE PAGE*/
	/*HEAD*/
	include 'templates/header.php';
	/*HEADER*/

	/*CONTENT*/
	switch ($aUrl()[1]) {
	    case 'FAQ':
	    	echo 'incl FAQ CONTENT';
	        break;
	    default:
	        echo '</br></br>code to be executed if n is different from all labels</br>';
	} 
	/*FOOTER*/

	/*END OF BODY*/

	var_dump($aUrl()[0]);
	print_r($aUrl()[1]);
		echo '<br> ';
	if(isset($aUrl()[2])){
		echo $aUrl()[2];
		echo '<br> ';
	}
	if(isset($aUrl()[3])){
		echo $aUrl()[3];
		echo '<br> ';
	}
	if(isset($aUrl()[4])){
		echo $aUrl()[4];
		echo '<br> ';
	}
/*
	include 'templates/header.php';

	//Problem: switch is sensitive to upper/lower case
	//Solution: set everything to uppercase right before exploding the url
	switch ($aUrl[0]) {
	    case 'FAQ':
	        include 'pages/faq.php';
	        break;
	    case 'PROFILE':
	    	switch ($url->explodedUri)
	        echo '</br></br>code to be executed if n=label2</br>';
	        break;
	    case 'label3':
	        echo '</br></br>code to be executed if n=label3</br>';
	        break;
	    default:
	        echo '</br></br>code to be executed if n is different from all labels</br>';
	} 

	include 'templates/footer.php';
*/
?>
